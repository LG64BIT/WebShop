<?php
namespace app\controllers;

use app\models\Categories;
use app\models\Model;
use app\models\Product;
use PDO;

class HomeController
{
    protected PDO $db;
    public function __construct(PDO $db)
    {
        $this->db=$db;
    }

    public function index($response)
    {
        new Model($this->db);
        if(isset($_GET['category']))
            return $this->filter($response);
        return $this->showAll($response);
    }

    public function showAll($response)
    {
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProducts(10),
        ]);
    }

    public function filter($response)
    {
        $category = $this->db->prepare("SELECT name FROM categories WHERE id=:id");
        $category->execute(['id'=>$_GET['category']]);
        $category = $category->fetchAll(PDO::FETCH_CLASS)[0];
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProductsByCategory($_GET['category']),
            'currentCategoryName' => $category->name,
        ]);
    }
}