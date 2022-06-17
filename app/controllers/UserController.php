<?php
namespace app\controllers;

use app\exceptions\NoPermissionException;
use app\models\User;
use PDO;

class UserController
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function renderAllUsers($response)
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException('You do not have permission to do that!');
        $users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserList.php', [
            'users' => $users
        ]);
    }
}