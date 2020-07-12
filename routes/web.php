<?php

use App\Support\Route;

Route::get(   '/',                              'HomeController@react');
Route::get(   '/login',                         'HomeController@react');
Route::get(   '/dashboard[/{params:.*}]',       'HomeController@react');
Route::get(   '/knowledgebase[/{params:.*}]',   'HomeController@react');
