<?php

namespace App\controllers;

use App\exceptions\NoPermissionException;
use App\models\User;

class RegisterController
{
    public function register($response)
    {
        if(!isset($_SESSION['id'])) {
            return $response->setBody('app/views/RegisterForm.php');
        }
        throw new NoPermissionException('You do not have permission to do that!');
    }

    public function submit()
    {
        if(!isset($_POST['email'], $_POST['password'])) {
            $_SESSION['registerMessage'] = "Empty credentials!";
            header("Location: ../register");
            return;
        }
        $user = new User(trim($_POST['email']), trim($_POST['password']));
        if(!$user->validateEmail() || !$user->validatePassword()) {
            header("Location: ../register");
            return;
        }
        $user->register();
        unset($_SESSION['registerMessage']);
        header("Location: ../login");
    }
}
