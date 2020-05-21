<?php

use App\Support\Route;

Route::get('/admin',         'AdminPanelController@dashboard');
Route::get('/admin/react/',   'AdminPanelController@react');