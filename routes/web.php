<?php

use App\Support\Route;

Route::get('/',         'HomeController@index');
Route::get('/users',    'HomeController@users');
Route::get('/kbase',    'HomeController@knowledgebase');