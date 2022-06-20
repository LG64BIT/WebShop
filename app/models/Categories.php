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
}