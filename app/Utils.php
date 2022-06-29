<?php

namespace App;

use PDO;

class Utils
{
    protected static PDO $db;

    public static function getDb(): PDO
    {
        return self::$db;
    }

    public static function setDb(PDO $db): void
    {
        self::$db = $db;
    }
}