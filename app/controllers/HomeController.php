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
            'categories' => Categories::GetAllCategories()
        ]);
    }

    public function filter($response)
    {
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProductsCategorized($_GET['category'], 10),
            'categories' => Categories::GetAllCategories()
        ]);
    }
}