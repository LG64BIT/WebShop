<?php
namespace App\models;

 use PDO;

 abstract class Model
 {
     protected static PDO $db;

     public function __construct(PDO $db)
     {
         self::$db = $db;
     }
 }
