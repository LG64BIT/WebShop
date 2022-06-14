<?php
namespace app\controllers;

class HomeController
{
    public function index($response)
    {
        return $response->setBody('app/views/Home.php');
    }
    public function login($response)
    {
        return $response->setBody('app/views/LoginForm.php');
    }
}