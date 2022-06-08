<?php
namespace app\controllers;

class HomeController
{
    public function index($response)
    {
        return $response->setBody('Home');
    }
}