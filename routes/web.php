<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) { 

    $router->post('login', 'AuthController@login');

    $router->post('register', 'AuthController@register');

    $router->post('logout', 'AuthController@logout');

    $router->group(['prefix' => 'categories'], function () use ($router) { 
        $router->get('/','CategoriesController@index');
        $router->post('/','CategoriesController@store');
        $router->delete('/{category}','CategoriesController@destroy');
        $router->put('/{category}','CategoriesController@update');
    });
     
 
 });