<?php

namespace app\controllers;

use app\exceptions\NoPermissionException;
use app\models\User;
use PDO;

class LoginController
{
    protected User $user;

    public function __construct(PDO $db = null)
    {
        if($db != null && isset($_POST['username'], $_POST['password']))
            $this->user = new User($db, $_POST['username'], $_POST['password']);
    }

    public function login($response)
    {
        if(!isset($_SESSION['login']))
            return $response->setBody('app/views/LoginForm.php');
        //return $response->setBody('app/views/ErrorPage.php');
        throw new NoPermissionException('You do not have permission to do that!');
    }
    
    public function logout()
    {
        session_unset();
        header("Location: login");
    }

    public function submit()
    {
        if($this->user->login())
        {
            unset($_SESSION['loginMessage']);
            header("Location: ../home");
            return;
        }
        $_SESSION['loginMessage'] = "Invalid credentials!";
        header("Location: ../login");
    }
}