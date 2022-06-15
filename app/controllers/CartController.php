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
            return $response->setBody('app/views/CartView.php');
        throw new NoPermissionException('You do not have permission to do that!');
    }

    public function add()
    {
        if(isset($_GET['id']))
        {
            if(!isset($_SESSION['cart'][$_GET['id']]))
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
}