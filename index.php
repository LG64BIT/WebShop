<?php
require_once "autoloader/autoloader.php";

session_start();
$app = new app\App;
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
$app->get('/', [new \app\controllers\HomeController($container->db), 'index']);
$app->get('/home', [new \app\controllers\HomeController($container->db), 'index']);

$app->get('/register', [\app\controllers\RegisterController::class, 'register']);
$app->post('/register/submit', [new \app\controllers\RegisterController($container->db), 'submit']);

$app->get('/login', [\app\controllers\LoginController::class, 'login']);
$app->post('/login/submit', [new \app\controllers\LoginController($container->db), 'submit']);
$app->get('/logout', [\app\controllers\LoginController::class, 'logout']);

$app->get('/cart', [new \app\controllers\CartController($container->db), 'render']);
$app->get('/cart/add', [new \app\controllers\CartController($container->db), 'add']);
$app->get('/cart/empty', [new \app\controllers\CartController($container->db), 'empty']);
$app->get('/cart/addQuantity', [new \app\controllers\CartController($container->db), 'addQuantity']);
$app->get('/cart/removeQuantity', [new \app\controllers\CartController($container->db), 'removeQuantity']);
$app->post('/cart/order', [new \app\controllers\CartController($container->db), 'processOrder']);
$app->get('/orderForm', [new \app\controllers\CartController($container->db), 'orderForm']);

$app->get('/addProduct', [new \app\controllers\ProductController($container->db), 'add']);
$app->get('/editProduct', [new \app\controllers\ProductController($container->db), 'edit']);
$app->get('/removeProduct', [new \app\controllers\ProductController($container->db), 'remove']);
$app->post('/addProduct/submit', [new \app\controllers\ProductController($container->db), 'submit']);

$app->get('/allUsers', [new \app\controllers\UserController($container->db), 'renderAllUsers']);
$app->get('/editUser', [new \app\controllers\UserController($container->db), 'editUser']);
$app->post('/editUser/submit', [new \app\controllers\UserController($container->db), 'submit']);
$app->get('/removeUser', [new \app\controllers\UserController($container->db), 'removeUser']);

$app->run();