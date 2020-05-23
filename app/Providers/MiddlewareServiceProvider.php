<?php


namespace App\Providers;

use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\SecurityMiddleware;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function register()
    {
        try {
            $this->app->add(new SecurityMiddleware());
            $this->app->addBodyParsingMiddleware();

            // This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
            $this->app->options('/{routes:.+}', function ($request, $response, $args) {
                return $response;
            });
                                                            // TODO SECURITY

            $this->app->add(function ($request, $handler) {
                $response = $handler->handle($request);
                return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                    // Optional: Allow Ajax CORS requests with Authorization header
                    ->withHeader('Access-Control-Allow-Credentials', 'true');
            });
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