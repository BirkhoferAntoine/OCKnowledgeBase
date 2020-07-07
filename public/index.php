<?php
declare(strict_types=1);

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use App\Providers\ServiceProvider;

/*session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
]);*/

require __DIR__ . '/../vendor/autoload.php';

$app = SlimAppFactory::create(new Container);

ServiceProvider::setup($app, config('app.providers'));

$app->run();

/*
 * TODO Add comments ; CTRL+SHIFT+/ ;
*/

