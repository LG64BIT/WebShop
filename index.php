<?php
require_once "autoloader/autoloader.php";

session_start();
$app = new \app\App;
$container = $app->getContainer();
$container['config'] = function () {
    return [
            'db_driver' => 'mysql',
            'db_host' => 'localhost',
            'db_name' => 'shop',
            'db_user' => 'root',
            'db_pass' => 'Admin1234?',
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
        return $response->setBody('Page not found')->withStatus(404);
    };
};
$app->get('/', [\app\controllers\HomeController::class, 'index']);
//$app->get('/users', [new \app\controllers\UserController($container->db), 'index']);
$app->get('/home', [\app\controllers\HomeController::class, 'index']);

$app->get('/register', [\app\controllers\RegisterController::class, 'register']);
$app->post('/register/submit', [new \app\controllers\RegisterController($container->db), 'submit']);

$app->get('/login', [\app\controllers\LoginController::class, 'login']);
$app->post('/login/submit', [new \app\controllers\LoginController($container->db), 'submit']);
$app->get('/logout', [\app\controllers\LoginController::class, 'logout']);

$app->run();