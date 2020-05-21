<?php


namespace App\Providers;

use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\SecurityMiddleware;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function register()
    {
        try {
        $this->app->add(new SecurityMiddleware());
        $this->app->addBodyParsingMiddleware();
        } catch (Exception $e) {
            if (env('APP_DEBUG', false))
                throw new ClassNotFoundException('Erreur ' . var_export(self::class) . ' n\'est pas fonctionnel', $e);
        }
    }

    public function boot()
    {
        //$this->app->getMiddlewareDispatcher()->
    }
}