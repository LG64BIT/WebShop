<?php

use App\App;
use App\Container;
use App\controllers\CartController;
use App\controllers\HomeController;
use App\controllers\LoginController;
use App\controllers\OrderController;
use App\controllers\ProductController;
use App\controllers\RegisterController;
use App\controllers\UserController;
use App\Response;
use App\Router;
use App\Utils;

require_once "autoloader/autoloader.php";

session_start();
$app = new App(new Container([
            'router' => function() {
                return new Router;
            },
            'response' => function() {
                return new Response;
            }
        ]));
$container = $app->getContainer();
$container['config'] = function () {
    return [
            'db_driver' => 'mysql',
            'db_host' => 'localhost',
            'db_name' => 'shop',
            'db_user' => 'root',
            'db_pass' => '',
    ];
};
$container['db'] = function ($c) {
    return new PDO(
        "{$c->config['db_driver']}:host={$c->config['db_host']};dbname={$c->config['db_name']};charset=UTF8",
        $c->config['db_user'],
        $c->config['db_pass']
    );
};
$container['errorHandler'] = function () {
    return function ($response) {
        return $response->setBody('app/views/ErrorPage.php')->withStatus(404);
    };
};

Utils::setDb($container->db);

$app->get('/', [HomeController::class, 'index']);
$app->get('/home', [HomeController::class, 'index']);
$app->get('/about', [HomeController::class, 'renderAbout']);

$app->get('/register', [RegisterController::class, 'register']);
$app->post('/register/submit', [RegisterController::class, 'submit']);

$app->get('/login', [LoginController::class, 'login']);
$app->post('/login/submit', [LoginController::class, 'submit']);
$app->get('/logout', [LoginController::class, 'logout']);

$app->get('/cart', [CartController::class, 'render']);
$app->get('/cart/add', [CartController::class, 'add']);
$app->get('/cart/empty', [CartController::class, 'empty']);
$app->get('/cart/addQuantity', [CartController::class, 'addQuantity']);
$app->get('/cart/removeQuantity', [CartController::class, 'removeQuantity']);
$app->post('/cart/order', [CartController::class, 'processOrder']);
$app->get('/orderForm', [CartController::class, 'orderForm']);

$app->get('/allOrders', [OrderController::class, 'allOrders']);
$app->get('/orderHistory', [OrderController::class, 'showHistory']);
$app->post('/allOrders/updateUserStatus', [OrderController::class, 'updateUserStatus']);
$app->post('/allOrders/updateGuestStatus', [OrderController::class, 'updateGuestStatus']);

$app->get('/product', [ProductController::class, 'renderProduct']);
$app->get('/addProduct', [ProductController::class, 'add']);
$app->get('/editProduct', [ProductController::class, 'edit']);
$app->get('/removeProduct', [ProductController::class, 'remove']);
$app->post('/addProduct/submit', [ProductController::class, 'submit']);

$app->get('/allUsers', [UserController::class, 'renderAllUsers']);
$app->get('/editUser', [UserController::class, 'editUser']);
$app->post('/editUser/submit', [UserController::class, 'submit']);
$app->get('/removeUser', [UserController::class, 'removeUser']);
$app->get('/profile', [UserController::class, 'renderProfile']);
$app->post('/editUser/updatePassword', [UserController::class, 'updatePassword']);
$app->post('/editUser/updateInfo', [UserController::class, 'updateInfo']);

$app->run();
