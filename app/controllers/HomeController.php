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
        $model = new Model($this->db);
        return $response->setBody('app/views/Home.php', [
            'products' => Product::getAllProducts(),
        ]);
    }
}