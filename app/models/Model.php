<?php
namespace app\models;
 use PDO;

 class Model
 {
     protected static PDO $db;

     public function __construct(PDO $db)
     {
         self::$db = $db;
     }
 }