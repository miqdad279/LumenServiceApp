<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('customers', 'CustomersController@index');
$router->get('produks', 'ProduksController@index');
$router->get('bukus', 'BukusController@index');
$router->post('bukus', 'BukusController@store');
$router->get('bukus/{id}', 'BukusController@show');
$router->put('bukus/{id}', 'BukusController@update');
$router->delete('bukus/{id}', 'BukusController@destroy');
$router->get('ebooks', 'EbooksController@index');
$router->get('keranjangs', 'KeranjangsController@index');
