<?php

use App\Support\Route;

Route::get('/api/v1/get',               'APIController@get');
Route::post('/api/v1/add',              'APIController@add');