<?php


namespace App\Controllers;

use App\Support\Security;
use App\Support\View;
use App\Models\ContentModelManager;
use Slim\Http\ServerRequest as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdminPanelController
{
    public function dashboard(Response $response, View $view, $with=null)
    {
        //require('../coreui-react/build/index.html'
        ob_start();
        require (base_path('/coreui-react/build/index.html'));
        $data = ob_get_clean();
       //dd($data);
        $payload = json_encode($data);
        //$payload = json_decode($data);
        //$response->getBody()->write($data);
        //return $response->getBody()->write($data);
        //return $response->withHeader('Content-Type', 'application/json');
            //('Content-Type', 'application/json');

        /*        $data = require (base_path('/coreui-react/build/index.html'));
                $payload = json_encode($data);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json');*/

/*        return $view('resources/views/adminDashboard.twig', [
            'headTitle' => env('APP_NAME', 'KnowledgeBase'),
            'name' => $user ?: 'Anonymous User',
            'body' => $data
        ]);*/
    }

    public function react(Response $response, View $view)
    {
        //base_path('/TestReact/coreui-free-react-admin-template-master/public/index.html')
        return $view('/TestReact/coreui-free-react-admin-template-master/public/index.html',[]);
        //return $response->getBody()->write();
    }
}