<?php


namespace App\Controllers;

use App\Models\APIContentModelManager;
use App\Support\Security;
use App\Support\View;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\ServerRequest as Request;

class APIController
{
    public function get(View $view, APIContentModelManager $modelManager)
    {
        $data       = $modelManager->get();
        $payload    = json_encode($data, JSON_PRETTY_PRINT);

        return $view('apiGet.twig', [
            'output' => $payload
            ],
        'Content-Type', 'application/json'
        );
    }

    public function post(Request $request, View $view, APIContentModelManager $modelManager)
    {
        $add        = $modelManager->add($request->getParams());
        $payload    = json_encode('Success!', JSON_PRETTY_PRINT);

        return $view('apiPost.twig', [
            'output' => $payload
        ],
            'Content-Type', 'application/json'
        );
    }

    public function put(Request $request, View $view, APIContentModelManager $modelManager)
    {
        $put        = $modelManager ->update($request->getParams());
        $payload    = json_encode('Success!', JSON_PRETTY_PRINT);

        return $view('apiPut.twig', [
            'output' => $payload
        ],
            'Content-Type', 'application/json'
        );
    }

    public function delete(View $view, APIContentModelManager $modelManager)
    {
        $delete         = $modelManager ->delete();
        $payload        = json_encode('Success!', JSON_PRETTY_PRINT);

        return $view('apiDelete.twig', [
            'output' => $payload
        ],
            'Content-Type', 'application/json'
        );
    }
}