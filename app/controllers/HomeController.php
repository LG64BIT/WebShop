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
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getProducts(10),
            'categories' => Categories::GetAllCategories()
        ]);
    }

    public function filter()
    {
        if(isset($_POST['submit']))
        {
            //$this->db->query("SELECT * FROM products WHERE ") TODO...
        }
    }
}