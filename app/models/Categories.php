<?php
namespace app\models;

use PDO;

class Categories extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public static function GetAllCategories()
    {
        $categories = self::$db->query("SELECT * FROM categories");
        return $categories->fetchAll(PDO::FETCH_CLASS);
    }

    public static function GetCategoriesOfProduct($productId)
    {
        $categories = self::$db->prepare("SELECT categories.id, categories.name FROM products, categories, product_category WHERE categories.id=category_id AND products.id=:id AND product_id=:id");
        $categories->execute(['id' => $productId]);
        return $categories->fetchAll(PDO::FETCH_CLASS);
    }
}