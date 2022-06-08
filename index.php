<?php
require_once "autoloader/autoloader.php";

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

/*$container['errorHandler'] = function ($c) {
    return function ($response) use ($c) {
        return $response->withBody('Page not found')->withStatus(404);
    };
};*/

$app->get('/', [\app\controllers\HomeController::class, 'index']);
$app->get('/users', [new \app\controllers\UserController($container->db), 'index']);

$app->run();