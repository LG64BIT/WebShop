<?php
namespace App\controllers;

use App\exceptions\NoPermissionException;
use App\exceptions\PageNotFoundException;
use App\Utils;
use PDO;

class UserController
{
    public function renderAllUsers($response)
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException('You do not have permission to do that!');
        }
        unset($_SESSION['userViewMessage']);
        $users = Utils::getDb()->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserList.php', [
            'users' => $users
        ]);
    }

    public function editUser($response)
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException;
        }
        if(!isset($_GET['id'])) {
            throw new PageNotFoundException('No user selected to delete');
        }
        $user = Utils::getDb()->prepare("SELECT * FROM users WHERE id=:id");
        $user->execute(['id'=>$_GET['id']]);
        $user = $user->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserView.php', [
            'user' => $user[0],
            'isAdmin' => true
        ]);
    }
    public function submit()
    {
        $user = Utils::getDb()->prepare("UPDATE users SET isAdmin=:isAdmin WHERE id=:id");
        $user->execute([
            'isAdmin'=>$_POST['isAdmin'],
            'id'=>$_POST['id']
        ]);
        $_SESSION['userViewMessage'] = "User successfully updated!";
        header('Location: ../editUser?id=' . $_POST['id']);
    }

    public function removeUser()
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException;
        }
        if(!isset($_GET['id'])) {
            throw new PageNotFoundException('No user selected to delete');
        }
        Utils::getDb()->prepare("DELETE FROM users WHERE id=:id")->execute(['id'=>$_GET['id']]);
        header('Location: allUsers');
    }

    public function renderProfile($response)
    {
        if (!isset($_SESSION['id'])) {
            throw new NoPermissionException;
        }
        $user = Utils::getDb()->prepare("SELECT * FROM users WHERE id=:id");
        $user->execute(['id' => $_SESSION['id']]);
        $user = $user->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/UserView.php', [
            'user' => $user[0],
            'isAdmin' => false
        ]);
    }

    public function updatePassword()
    {
        $pass = Utils::getDb()->prepare("SELECT password FROM users WHERE id=:id");
        $pass->execute(['id' => $_POST['id']]);
        $pass = $pass->fetchAll()[0][0];
        if(!password_verify($_POST['oldPassword'], $pass)) {
            $_SESSION['userViewMessage'] = 'Old password is not correct!';
            header('Location: ../profile');
            return;
        }
        if(strlen($_POST['newPassword'])<8) {
            $_SESSION['userViewMessage'] = "Password must be at least 8 characters long!";
            header('Location: ../profile');
            return;
        }
        if(strcmp($_POST['newPassword'], $_POST["repeat"])) {
            $_SESSION['userViewMessage'] = "Passwords are not equal!";
            header('Location: ../profile');
            return;
        }
        $user = Utils::getDb()->prepare("UPDATE users SET password=:password WHERE id=:id");
        $user->execute([
            'password' => password_hash($_POST['newPassword'], PASSWORD_DEFAULT),
            'id' =>  $_POST['id']
        ]);
        $_SESSION['userViewMessage'] = "Password updated successfully";
        header('Location: ../profile');
    }

    public function updateInfo()
    {
        $info = Utils::getDb()->prepare("UPDATE users SET firstName=:fname, lastName=:lname, address=:address, phone=:phone WHERE id=:id");
        $info->execute([
            'id' => $_POST['id'],
            'fname' => trim($_POST['fname']),
            'lname' => trim($_POST['lname']),
            'address' => trim($_POST['address']),
            'phone' => $_POST['phone']
        ]);
        $_SESSION['userViewMessage'] = "Info updated successfully";
        header('Location: ../profile');
    }
}
