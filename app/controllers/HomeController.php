<?php
namespace App\controllers;

use App\models\Categories;
use App\models\Product;
use App\Utils;
use PDO;

class HomeController
{
    public function index($response)
    {
        if(isset($_GET['category'])) {
            return $this->filter($response);
        }
        return $this->showAll($response);
    }

    public function showAll($response)
    {
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProducts(),
            'categories' => Categories::getAllCategories()
        ]);
    }

    public function filter($response)
    {
        $category = Utils::getDb()->prepare("SELECT name FROM categories WHERE id=:id");
        $category->execute(['id'=>$_GET['category']]);
        $category = $category->fetchAll(PDO::FETCH_CLASS)[0];
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProductsByCategory($_GET['category']),
            'currentCategoryName' => $category->name,
            'categories' => Categories::getAllCategories()
        ]);
    }

    public function renderAbout($response)
    {
        return $response->setBody('app/views/About.php');
    }
}
