<?php
declare(strict_types=1);

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use App\Providers\ServiceProvider;

session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
]);

// Constante contenant l'url de l'index
define('URL', str_replace(
    'index.php', '', 'https://' . filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_URL) . filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_URL)
    ));

require __DIR__ . '/../vendor/autoload.php';

$app = SlimAppFactory::create(new Container);

ServiceProvider::setup($app, config('app.providers'));

$app->run();

/*
 * TODO Add comments ; CTRL+SHIFT+/ ;
*/




// Add Routing Middleware
//$app->addRoutingMiddleware();

