<?php


namespace App\Controllers;

use App\Support\View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function react(View $view) {

        return $view('templates/web.twig', []
        );
    }
}