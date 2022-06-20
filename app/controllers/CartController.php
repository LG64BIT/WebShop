<?php
namespace app\controllers;

use app\exceptions\NoPermissionException;
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
        if(isset($_SESSION['login']))
            return $response->setBody('app/views/CartView.php', [
                'totalPrice' => $this->getTotalPrice()
            ]);
        throw new NoPermissionException('You do not have permission to do that!');
    }

    public function add()
    {
        if(isset($_GET['id']))
        {
            if(!isset($_SESSION['cart']['products'][$_GET['id']]))
            {
                $product = $this->db->prepare("SELECT * FROM products WHERE id=:id");
                $product->execute([
                    'id'=> $_GET['id']
                ]);
                $product = $product->fetchAll(PDO::FETCH_CLASS);
                $_SESSION['cart']['products'][$_GET['id']] = $product;
                $_SESSION['cart'][$_GET['id']]['quantity'] = 1;
            }
            else
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
            foreach ($_SESSION['cart']['products'] as $product)
                if($product[0]->id == $_GET['id'])
                    $_SESSION['cart'][$product[0]->id]['quantity'] += 1;
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

    public function order()
    {
        foreach ($_SESSION['cart']['products'] as $product) {
            $order = $this->db->prepare("INSERT INTO orders (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $order->execute([
                'user_id' => $_SESSION['id'],
                'product_id' => $product[0]->id,
                'quantity' => $_SESSION['cart'][$product[0]->id]['quantity']
            ]);
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
}