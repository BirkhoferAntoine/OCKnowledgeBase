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

        if ($headName && $headValue) return $this->response->withHeader($headName, $headValue);
        return $this->response;

    }
}