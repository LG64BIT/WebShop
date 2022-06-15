<?php
namespace app\models;

use PDO;

class Product extends Model
{
    protected $name;
    protected $price;
    protected $description;

    public function __construct(PDO $db, $name, $price, $description)
    {
        parent::__construct($db);
        $this->name=$name;
        $this->price=$price;
        $this->description=$description;
    }

    public static function getAllProducts()
    {
        $products = self::$db->prepare("SELECT * FROM products");
        $products->execute();
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

}