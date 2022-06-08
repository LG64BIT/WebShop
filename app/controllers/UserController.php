<?php
namespace app\controllers;

use app\models\User;
use PDO;

class UserController
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function index($response)
    {
        $users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS, User::class);

        return $response->withJson($users);
    }
}