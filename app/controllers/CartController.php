<?php
namespace app\controllers;

use app\exceptions\NoPermissionException;
use DateTime;
use PDO;

class CartController
{
    protected PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function render($response)
    {
        return $response->setBody('app/views/CartView.php', [
            'totalPrice' => $this->getTotalPrice()
        ]);
    }

    public function add()
    {
        if(isset($_GET['id']))
        {
            $product = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $product->execute([
                'id'=> $_GET['id']
            ]);
            $product = $product->fetchAll(PDO::FETCH_CLASS);
            if(!isset($_SESSION['cart']['products'][$_GET['id']]))
            {
                $_SESSION['cart']['products'][$_GET['id']] = $product;
                $_SESSION['cart'][$_GET['id']]['quantity'] = 1;
            }
            else if($product[0]->quantity > $_SESSION['cart'][$_GET['id']]['quantity'])
                $_SESSION['cart'][$_GET['id']]['quantity'] += 1;
            header("Location: ../home");
        }
    }

    public function empty()
    {
        unset($_SESSION['cart']);
        header('Location: ../cart');
    }

    public function addQuantity()
    {
        if(isset($_GET['id']))
        {
            if($_SESSION['cart']['products'][$_GET['id']][0]->quantity > $_SESSION['cart'][$_GET['id']]['quantity'])
                $_SESSION['cart'][$_GET['id']]['quantity'] += 1;
        }
        header('Location: ../cart');
    }

    public function removeQuantity()
    {
        if(!isset($_GET['id']))
        {
            header('Location: ../cart');
            return;
        }
        foreach ($_SESSION['cart']['products'] as $product)
        {
            if(!($product[0]->id == $_GET['id']))
                continue;
            if($_SESSION['cart'][$product[0]->id]['quantity'] > 1)
                $_SESSION['cart'][$product[0]->id]['quantity'] -= 1;
            else
            {
                unset($_SESSION['cart']['products'][$_GET['id']]);
                unset($_SESSION['cart'][$_GET['id']]);
            }
        }
        header('Location: ../cart');
    }

    public function orderForm($response)
    {
        if(isset($_SESSION['login']))
        {
            $user = $this->db->prepare("SELECT * FROM users WHERE id=:id");
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
        if(isset($_SESSION['login']))
        {
            //process user orders
            //1. save user details to db
            $user = $this->db->prepare("UPDATE users SET firstName=:fname, lastName=:lname, email=:email, address=:address, phone=:phone WHERE id=:id");
            $user->execute([
                'id' => $_SESSION['id'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone']
            ]);
            //2. create order record in db
            foreach ($_SESSION['cart']['products'] as $product) {
                $order = $this->db->prepare("INSERT INTO user_orders (user_id, product_id, status, quantity, date) VALUES (:user_id, :product_id, :status, :quantity, :date)");
                $order->execute([
                    'user_id' => $_SESSION['id'],
                    'product_id' => $product[0]->id,
                    'status' => 'pending',
                    'quantity' => $_SESSION['cart'][$product[0]->id]['quantity'],
                    'date' => $currentDate->format('Y-m-d H:i:s')
                ]);
                $this->decrementQuantity($product[0]->id, $_SESSION['cart'][$product[0]->id]['quantity']);
            }
        }
        else
        {
            // same but for guest
            $user = $this->db->prepare("INSERT INTO guests (firstName,lastName,email,address,phone) VALUES (:fname,:lname,:email,:address,:phone)");
            $user->execute([
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone']
            ]);
            $guestId = $this->db->lastInsertId();
            foreach ($_SESSION['cart']['products'] as $product) {
                $order = $this->db->prepare("INSERT INTO guest_orders (guest_id, product_id, status, quantity, date) VALUES (:guest_id, :product_id, :status, :quantity, :date)");
                $order->execute([
                    'guest_id' => $guestId,
                    'product_id' => $product[0]->id,
                    'status' => 'pending',
                    'quantity' => $_SESSION['cart'][$product[0]->id]['quantity'],
                    'date' => $currentDate->format('Y-m-d H:i:s')
                ]);
                $this->decrementQuantity($product[0]->id, $_SESSION['cart'][$product[0]->id]['quantity']);
            }
        }
        //echo "<script>alert('You order has been saved to database!')</script>"; //kako napraviti feedback nakon obavljanja ordera
        $this->empty();
    }

    protected function getTotalPrice()
    {
        $sum = 0;
        if(!isset($_SESSION['cart']['products']))
            return $sum;
        foreach ($_SESSION['cart']['products'] as $product) {
            $sum += $product[0]->price * $_SESSION['cart'][$product[0]->id]['quantity'];
        }
        return $sum;
    }

    private function decrementQuantity($productId, mixed $boughtQuantity)
    {
        $currentQuantity = $this->db->prepare("SELECT quantity FROM products WHERE id=:id");
        $currentQuantity->execute(['id' => $productId]);
        $currentQuantity = $currentQuantity->fetch()[0];
        $newQuantity = $currentQuantity - $boughtQuantity;
        if($newQuantity<0)
        {
            return;
        }
        $this->db->prepare("UPDATE products SET quantity=:quantity WHERE id=:id")
            ->execute([
                'id' => $productId,
                'quantity' => $newQuantity
            ]);
    }
}