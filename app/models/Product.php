<?php
namespace app\models;

use PDO;

class Product extends Model
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $quantity;
    protected $image;
    protected $categories = [];

    public function __construct(PDO $db, $name, $price, $description, $quantity, $categories, $image, $id = 0)
    {
        parent::__construct($db);
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

    public static function getProducts(int $count = 10)
    {
        $products = self::$db->query("SELECT * FROM products LIMIT " . $count);
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

    public static function getProductsCategorized(int $count = 10)
    {
        $products = self::$db->query("SELECT products.id AS pId, products.name AS pName,
        price, description, image, categories.id AS cId, categories.name AS cName
        FROM products, categories, product_category WHERE products.id = product_id AND categories.id = category_id LIMIT " . $count);
        return $products->fetchAll(PDO::FETCH_CLASS);
    }

    public function insertIntoDataBase()
    {
        $product = self::$db->prepare("INSERT INTO products (name, price, description, quantity, image) VALUES (:name, :price, :description, :quantity, :image)");
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
        if($this->image != '')
        {
            $product = self::$db->prepare("UPDATE products SET name=:name, price=:price, description=:description, quantity=:quantity, image=:image WHERE id=:id");
            $product->execute([
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'image' => $this->image
            ]);
            return;
        }
        $product = self::$db->prepare("UPDATE products SET name=:name, price=:price, description=:description, quantity=:quantity WHERE id=:id");
        $product->execute([
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity
        ]);
    }
}