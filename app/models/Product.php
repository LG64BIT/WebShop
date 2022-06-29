<?php
namespace App\models;

use App\Utils;
use PDO;

class Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $quantity;
    protected $image;
    protected $categories = [];

    public function __construct($name, $price, $description, $quantity, $categories, $image, $id = 0)
    {
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->description=$description;
        $this->quantity = $quantity;
        $this->categories = $categories;
        $this->image=$image;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public static function getProducts()
    {
        $products = Utils::getDb()->query("SELECT * FROM products");
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

    public static function getProductsByCategory($categoryId)
    {
        $products = Utils::getDb()->prepare("SELECT products.id AS id, products.name AS name,
        price, description, image, quantity FROM products, categories, product_category WHERE
        products.id = product_id AND categories.id = category_id AND categories.id = :id");
        $products->execute(['id' => $categoryId]);
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

    public function insertIntoDataBase()
    {
        if($this->image == '') {
            $this->image = 'default.png';
        }
        $product = Utils::getDb()->prepare("INSERT INTO products (name, price, description, quantity, image) VALUES (:name, :price, :description, :quantity, :image)");
        $product->execute([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'image' => $this->image
        ]);
    }

    public function updateDatabase()
    {
        if($this->image != '') {
            $product = Utils::getDb()->prepare("UPDATE products SET name=:name, price=:price, description=:description, quantity=:quantity, image=:image WHERE id=:id");
            $product->execute([
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'image' => $this->image
            ]);
        }
        else {
            $product = Utils::getDb()->prepare("UPDATE products SET name=:name, price=:price, description=:description, quantity=:quantity WHERE id=:id");
            $product->execute([
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'quantity' => $this->quantity,
            ]);
        }
    }
}
