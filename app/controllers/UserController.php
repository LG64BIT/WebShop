<?php
namespace app\controllers;

use app\exceptions\NoPermissionException;
use app\exceptions\PageNotFoundException;
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

    public function editUser($response)
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException;
        if(!isset($_GET['id']))
            throw new PageNotFoundException('No user selected to delete');
        $user = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $user->execute(['id'=>$_GET['id']]);
        $user = $user->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserView.php', [
            'user' => $user
        ]);
    }
    public function submit()
    {
        $user = $this->db->prepare("UPDATE users SET username=:username, isAdmin=:isAdmin WHERE id=:id");
        $user->execute([
            'username'=>$_POST['username'],
            'isAdmin'=>$_POST['isAdmin'],
            'id'=>$_POST['id']
        ]);
        header('Location: ../allUsers');
    }

    public function removeUser()
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException;
        if(!isset($_GET['id']))
            throw new PageNotFoundException('No user selected to delete');
        $this->db->prepare("DELETE FROM users WHERE id=:id")->execute(['id'=>$_GET['id']]);
        header('Location: allUsers');
    }
}