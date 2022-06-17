<?php
namespace app\controllers;

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
            'products' => Product::getAllProducts(),
            'productsPerPage' => 10,
            'columnCount' => 2,
        ]);
    }
}