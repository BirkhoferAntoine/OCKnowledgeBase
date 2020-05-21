<?php


namespace App\Controllers;

use App\Models\APIContentModelManager;
use App\Support\Security;
use App\Support\View;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\ServerRequest as Request;

class APIController
{
    public function get(View $view, APIContentModelManager $modelManager, Security $security, Response $response)
    {
        $data       = $modelManager->getContent();
        $payload    = json_encode($data, JSON_PRETTY_PRINT);

        return $view('apiGet.twig', [
            'output' => $payload
            ],
        'Content-Type', 'application/json'
        );
    }

    public function add(Response $response, APIContentModelManager $modelManager)
    {
        $add = $modelManager->addContent();/*
        if ($add['response'] === false) {
            $response->getBody()->write($add);
            return $response->withStatus('')*/
    }

    public function put(Request $request, Response $response, ContentModelManager $modelManager, $id)
    {
               /*$data = $modelManager();
               $payload = json_encode($data, JSON_PRETTY_PRINT);
               $response->getBody()->write($payload);

               return $response->withHeader('Content-Type', 'application/json');

        $user_name      = $request->getParam('user_name');
        $title          = $request->getParam('title');
        $content        = $request->getParam('content');
        $date           = $request->getParam('date');

        $sql = "UPDATE `Content` SET
				user_name 	= :user_name,
				title       = :title,
                content     = :content,
                date        = :date
			    WHERE id = :id";
    */
    }
}