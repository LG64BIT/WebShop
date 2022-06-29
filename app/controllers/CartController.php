<?php
namespace App\controllers;
use App\Utils;
use DateTime;
use PDO;

class CartController
{
    public function render($response)
    {
        if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0) {
            return $response->setBody('app/views/CartView.php', ['empty' => 'Cart is empty!']);
        }
        $products = [];
        foreach ($_SESSION['cart'] as $id => $qty) {
            $query = Utils::getDb()->prepare("SELECT * FROM products WHERE id=:id");
            $query->execute(['id' => $id]);
            $products[] = $query->fetchAll(PDO::FETCH_CLASS)[0];
        }
        return $response->setBody('app/views/CartView.php', [
            'totalPrice' => $this->getTotalPrice(),
            'products' => $products
        ]);
    }

    public function add()
    {
        if(!isset($_GET['id'])) {
            header("Location: ../home");
            return;
        }
        $qty = (int)$_GET['qty'];
        if($qty == 0) {
            $qty = 1;
        }
        $product = $this->getProductPriceQuantity($_GET['id']);
        if(!isset($_SESSION['cart'][$_GET['id']])) {
            $_SESSION['cart'][$_GET['id']] = min($qty, $product->quantity);
        }
        else if($product->quantity > $_SESSION['cart'][$_GET['id']]) {
            $_SESSION['cart'][$_GET['id']] = min($_SESSION['cart'][$_GET['id']] + $qty, $product->quantity);
        }
        header("Location: ../home");
    }

    public function empty()
    {
        unset($_SESSION['cart']);
        header('Location: ../cart');
    }

    public function addQuantity()
    {
        if(!isset($_GET['id'])) {
            header('Location: ../cart');
            return;
        }
        $product = $this->getProductPriceQuantity($_GET['id']);
        if($product->quantity > $_SESSION['cart'][$_GET['id']]) {
            $_SESSION['cart'][$_GET['id']] += 1;
        }
        header('Location: ../cart');
    }

    public function getProductPriceQuantity(int $id)
    {
        $product = Utils::getDb()->prepare("SELECT quantity, price FROM products WHERE id=:id");
        $product->execute([
            'id'=> $id
        ]);
        return $product->fetchAll(PDO::FETCH_CLASS)[0];
    }

    public function removeQuantity()
    {
        if(!isset($_GET['id'])) {
            header('Location: ../cart');
            return;
        }
        foreach ($_SESSION['cart'] as $id => $qty) {
            if(!($id == $_GET['id'])) {
                continue;
            }
            if($_SESSION['cart'][$id] > 1) {
                $_SESSION['cart'][$id] -= 1;
            }
            else {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: ../cart');
    }

    public function orderForm($response)
    {
        if(isset($_SESSION['id'])) {
            $user = Utils::getDb()->prepare("SELECT * FROM users WHERE id=:id");
            $user->execute(['id' => $_SESSION['id']]);
            $user = $user->fetchAll(PDO::FETCH_CLASS);
            return $response->setBody('app/views/OrderForm.php', [
                'user' => $user[0]
            ]);
        }
        return $response->setBody('app/views/OrderForm.php');
    }

    public function processOrder()
    {
        $currentDate = new DateTime();
        if(isset($_SESSION['id'])) {
            //1. save user details to db
            $user = Utils::getDb()->prepare("UPDATE users SET firstName=:fname, lastName=:lname, address=:address, phone=:phone WHERE id=:id");
            $user->execute([
                'id' => $_SESSION['id'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone']
            ]);
            //2. create order record in db
            foreach ($_SESSION['cart'] as $id => $qty) {
                $order = Utils::getDb()->prepare("INSERT INTO user_orders (user_id, product_id, status, quantity, date) VALUES (:user_id, :product_id, :status, :quantity, :date)");
                $order->execute([
                    'user_id' => $_SESSION['id'],
                    'product_id' => $id,
                    'status' => 'pending',
                    'quantity' => $qty,
                    'date' => $currentDate->format('Y-m-d H:i:s')
                ]);
                $this->decrementQuantity($id, $qty);
            }
        }
        else {
            // same but for guest
            $user = Utils::getDb()->prepare("INSERT INTO guests (firstName,lastName,email,address,phone) VALUES (:fname,:lname,:email,:address,:phone)");
            $user->execute([
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone']
            ]);
            $guestId = Utils::getDb()->lastInsertId();
            foreach ($_SESSION['cart'] as $id => $qty) {
                $order = Utils::getDb()->prepare("INSERT INTO guest_orders (guest_id, product_id, status, quantity, date) VALUES (:guest_id, :product_id, :status, :quantity, :date)");
                $order->execute([
                    'guest_id' => $guestId,
                    'product_id' => $id,
                    'status' => 'pending',
                    'quantity' => $qty,
                    'date' => $currentDate->format('Y-m-d H:i:s')
                ]);
                $this->decrementQuantity($id, $qty);
            }
        }
        $this->empty();
    }

    protected function getTotalPrice()
    {
        $sum = 0;
        if(!isset($_SESSION['cart'])) {
            return $sum;
        }
        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = $this->getProductPriceQuantity($id);
            $sum += $product->price * $qty;
        }
        return $sum;
    }

    private function decrementQuantity($productId, mixed $boughtQuantity)
    {
        $currentQuantity = Utils::getDb()->prepare("SELECT quantity FROM products WHERE id=:id");
        $currentQuantity->execute(['id' => $productId]);
        $currentQuantity = $currentQuantity->fetch()[0];
        $newQuantity = $currentQuantity - $boughtQuantity;
        if($newQuantity < 0) {
            return;
        }
        Utils::getDb()->prepare("UPDATE products SET quantity=:quantity WHERE id=:id")
            ->execute([
                'id' => $productId,
                'quantity' => $newQuantity
            ]);
    }
}
