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
            'user' => $user[0],
            'isAdmin' => true
        ]);
    }
    public function submit()
    {
        if(strlen($_POST['username'])>30 || strlen($_POST['username'])<3)
        {
            $_SESSION['userViewMessage'] = "Username must be between 3 and 30 characters long!";
            header('Location: ../editUser?id=' . $_POST['id']);
            return;
        }
        $user = $this->db->prepare("UPDATE users SET username=:username, isAdmin=:isAdmin WHERE id=:id");
        $user->execute([
            'username'=>$_POST['username'],
            'isAdmin'=>$_POST['isAdmin'],
            'id'=>$_POST['id']
        ]);
        $_SESSION['userViewMessage'] = "User successfully updated!";
        header('Location: ../editUser?id=' . $_POST['id']);
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

    public function renderProfile($response)
    {
        if (!isset($_SESSION['login']))
            throw new NoPermissionException;
        $user = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $user->execute(['id' => $_SESSION['id']]);
        $user = $user->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserView.php', [
            'user' => $user[0],
            'isAdmin' => false
        ]);
    }

    public function updatePassword()
    {
        $pass = $this->db->prepare("SELECT password FROM users WHERE id=:id");
        $pass->execute(['id' => $_POST['id']]);
        $pass = $pass->fetchAll()[0][0];
        if(!password_verify($_POST['oldPassword'], $pass))
        {
            $_SESSION['userViewMessage'] = 'Old password is not correct!';
            header('Location: ../profile');
            return;
        }
        if(strlen($_POST['newPassword'])<8)
        {
            $_SESSION['userViewMessage'] = "Password must be at least 8 characters long!";
            header('Location: ../profile');
            return;
        }
        if(strcmp($_POST['newPassword'], $_POST["repeat"]))
        {
            $_SESSION['userViewMessage'] = "Passwords are not equal!";
            header('Location: ../profile');
            return;
        }
        $user = $this->db->prepare("UPDATE users SET password=:password WHERE id=:id");
        $user->execute([
            'password' => password_hash($_POST['newPassword'], PASSWORD_DEFAULT),
            'id' =>  $_POST['id']
        ]);
        $_SESSION['userViewMessage'] = "Password updated successfully";
        header('Location: ../profile');
    }

    public function updateInfo()
    {
        $info = $this->db->prepare("UPDATE users SET firstName=:fname, lastName=:lname, email=:email, address=:address, phone=:phone WHERE id=:id");
        $info->execute([
            'id' => $_POST['id'],
            'fname' => trim($_POST['fname']),
            'lname' => trim($_POST['lname']),
            'email' => trim($_POST['email']),
            'address' => trim($_POST['address']),
            'phone' => $_POST['phone']
        ]);
        $_SESSION['userViewMessage'] = "Info updated successfully";
        header('Location: ../profile');
    }
}