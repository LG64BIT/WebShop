<?php
namespace app\models;

use PDO;

class Product extends Model
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $image;

    public function __construct(PDO $db, $name, $price, $description, $image, $id = 0)
    {
        parent::__construct($db);
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->description=$description;
        $this->image=$image;
    }

    public static function getAllProducts()
    {
        $products = self::$db->prepare("SELECT * FROM products");
        $products->execute();
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

    public function insertIntoDataBase()
    {
        $product = self::$db->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
        $product->execute([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image
        ]);
    }

    public function updateDatabase()
    {
        $product = self::$db->prepare("UPDATE products SET name=:name, price=:price, description=:description, image=:image WHERE id=:id");
        $product->execute([
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image
        ]);
    }

}