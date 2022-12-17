<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use FastRoute\Route;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('bukus', 'BukusController@index');
    $router->post('bukus', 'BukusController@store');
    $router->get('bukus/{id}', 'BukusController@show');
    $router->put('bukus/{id}', 'BukusController@update');
    $router->delete('bukus/{id}', 'BukusController@destroy');
});


$router->get('produks', 'ProduksController@index');
$router->get('customers', 'CustomersController@index');
$router->get('ebooks', 'EbooksController@index');
$router->get('keranjangs', 'KeranjangsController@index');


$router->group(['prefix' => 'auth'], function() use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->get('public/bukus', 'PublicController\BukusController@index');
$router->get('public/buku/{id}', 'PublicController\BukusController@show');