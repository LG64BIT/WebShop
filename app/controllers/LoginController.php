<?php

namespace app\controllers;

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
        return $response->setBody('app/views/LoginForm.php');
    }
    public function logout($response)
    {

        return $response->setBody('app/views/LoginForm.php');
    }

    public function submit($response)
    {
        if($this->user->login())
            header("Location: /");
        //echo "Invalid credentials!";
        header("Location: ../login");
    }
}