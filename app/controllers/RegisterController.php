<?php

namespace app\controllers;

use app\models\User;
use PDO;

class RegisterController
{
    protected User $user;
    public function __construct(PDO $db = null)
    {
        if($db != null && isset($_POST['username'], $_POST['password']))
            $this->user = new User($db, $_POST['username'], $_POST['password']);
    }

    public function register($response)
    {
        return $response->setBody('app/views/RegisterForm.php');
    }

    public function submit()
    {
        if(!$this->user->validateUsername() || !$this->user->validatePassword())
            return;
        $this->user->register();
        echo "Registered";
        //header("Location: login");
    }
}