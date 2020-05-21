<?php


namespace App\Controllers;

use App\Support\View;

class LoginController
{
    public function show(View $view)
    {
        return $view('login.twig');
    }

    public function store($redirect)
    {
        // TODO Redirect to
    }
}