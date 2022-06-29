<?php
namespace App\models;

use App\Utils;
use PDO;

class Categories
{
    public static function getAllCategories()
    {
        $categories = Utils::getDb()->query("SELECT * FROM categories");
        return $categories->fetchAll(PDO::FETCH_CLASS);
    }

    public static function getCategoriesOfProduct($productId)
    {
        $categories = Utils::getDb()->prepare("SELECT categories.id, categories.name FROM products, categories, product_category WHERE categories.id=category_id AND products.id=:id AND product_id=:id");
        $categories->execute(['id' => $productId]);
        return $categories->fetchAll(PDO::FETCH_CLASS);
    }
}
