<?php

namespace App\controllers;

use App\exceptions\NoPermissionException;
use App\models\User;

class LoginController
{
    public function login($response)
    {
        if(!isset($_SESSION['id'])) {
            return $response->setBody('app/views/LoginForm.php');
        }
        throw new NoPermissionException('You do not have permission to do that!');
    }
    
    public function logout()
    {
        session_unset();
        header("Location: login");
    }

    public function submit()
    {
        if(!isset($_POST['email'], $_POST['password'])) {
            header("Location: ../login");
            return;
        }
        $user = new User($_POST['email'], $_POST['password']);
        if($user->login()) {
            unset($_SESSION['loginMessage']);
            header("Location: ../home");
            return;
        }
        $_SESSION['loginMessage'] = "Invalid credentials!";
        header("Location: ../login");
    }
}
