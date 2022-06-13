<?php

namespace app\controllers;

class LoginController
{
    public function login($response)
    {
        return $response->setBody('app/views/LoginForm.php');
    }
}