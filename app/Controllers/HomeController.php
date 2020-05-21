<?php


namespace App\Controllers;

use App\Support\Security;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestFactoryInterface as Request;
use \Slim\Routing\RouteCollectorProxy;
use Slim\Psr7\Factory\ResponseFactory;

use App\Support\View;
use App\Models\UsersModelManager;
use App\Models\APIContentModelManager;

class HomeController
{
    public function index(View $view, $with=null)
    {
       return $view('resources/views/index.twig', [
            'headTitle' => env('APP_NAME', 'KnowledgeBase'),
            //'name' =>  $user ?: 'Anonymous User',
            //'body' => $data

        ]);
    }
    public function users(View $view, UsersModelManager $modelManager)
    {
        return $view('test.twig', [
            'output' => dump($modelManager())
        ]);
    }
    public function knowledgebase(View $view, APIContentModelManager $modelManager, Security $security)
    {

        return $view('build/index.html', [
            //'output' => dump($modelManager())
        ]);
    }


    /*public function test(RouteCollectorProxy $view)
    {

    }


     * function (RouteCollectorProxy $view)
{
    $view->get('example/{name}', function($request, $response, $args) {
        $name = $args['name'];

        return $this->get('view')->render($response, 'example.twig', compact('name'));
    });

    $view->get('/views/{name}', function ($request, $response, $args) {
        $view = 'example.twig';
        $name = $args['name'];

        return $this->get('view')->render($response, $view, compact('name'));
    });)
     */

}
