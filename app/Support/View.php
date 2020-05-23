<?php

namespace App\Support;

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;


class View
{
    public ResponseInterface $response;
    public $app;

    public function __construct(ResponseFactoryInterface $factory, $app)
    {
        $this->response = $factory->createResponse(200, 'Success');
        $this->app = &$app;
    }

    public function __invoke(string $template = '', array $with = [], $headName = null, $headValue = null) : ResponseInterface
    {
        $app = &$this->app;

        $cache = config('twig.cache');
        $path = resources_path('views');

        // Create Twig
        $twig = Twig::create($path, $cache);

        // Add Twig-View Middleware
        $app->add(TwigMiddleware::create($app, $twig));

        // Render Twig
        $twig->render($this->response, $template, $with);

        $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
            throw new HttpNotFoundException($request);
        });

        if ($headName && $headValue) {
            return $this->response->withHeader($headName, $headValue)
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                // Optional: Allow Ajax CORS requests with Authorization header
                ->withHeader('Access-Control-Allow-Credentials', 'true');
        }
            return $this->response;
    }
}