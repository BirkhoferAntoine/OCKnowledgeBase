<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware implements Middleware  // TODO SESSION HANDLER ?
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SERVER['HTTPS'])) {

            $currentCookieParams = session_get_cookie_params();
            dd($currentCookieParams);

            config('session.cookies');

            session_set_cookie_params(
                COOKIE_LIFETIME,
                COOKIE_PATH,
                COOKIE_ROOT_DOMAIN,
                COOKIE_SECURE,
                COOKIE_HTTPONLY
            );

            //session_name(C_NAME);

            // Check if session exists
            isset($_SESSION) ?: session_start(); // TODO WORKS AS MIDDLEWARE?

            // Refresh session timer each page loading
            setcookie(session_name(),session_id(),time()+COOKIE_LIFETIME);

            // Add session attribute to request
            $request = $request->withAttribute('session', $_SESSION);
            }

            return $handler->handle($request);
    }
}


/*
Attributes

With PSR-7 it is possible to inject objects/values into the request object for further processing. In your applications middleware often need to pass along information to your route closure and the way to do it is to add it to the request object via an attribute.

Example, Setting a value on your request object.

$app->add(function ($request, $handler) {
    // add the session storage to your request as [READ-ONLY]
    $request = $request->withAttribute('session', $_SESSION);
    return $handler->handle($request);
});

Example, how to retrieve the value.

$app->get('/test', function ($request, $response, $args) {
    $session = $request->getAttribute('session'); // get the session from the request
    return $response->write('Yay, ' . $session['name']);
});

The request object also has bulk functions as well. $request->getAttributes() and $request->withAttributes()*/
