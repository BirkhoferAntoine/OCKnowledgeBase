<?php

use App\Support\Route;

Route::get(     '/api/v1/get',                  'APIController@get');
Route::post(    '/api/v1/post',                 'APIController@post');
Route::put(     '/api/v1/put',                  'APIController@put');
Route::delete(  '/api/v1/delete',               'APIController@delete');
