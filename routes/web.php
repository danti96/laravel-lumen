<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->post('/register', ['uses' => 'UsersController@register']);
$router->post('/login', ['uses' => 'UsersController@login']);


$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/mascotas', ['uses' => 'MascotasController@index']);
    $router->post('/mascotas/create', ['uses' => 'MascotasController@register']);
    $router->get('/mascotas/{id}', ['uses' => 'MascotasController@search']);
    $router->put('/mascotas/{id}', ['uses' => 'MascotasController@update']);
    $router->delete('/mascotas/{id}', ['uses' => 'MascotasController@delete']);


    $router->get('/mascotas-cita', ['uses' => 'MascotasController@mascotascitas']);
    $router->post('/mascotas-cita/create', ['uses' => 'MascotasController@mascotasregister']);
    $router->get('/mascotas-cita/{id}', ['uses' => 'MascotasController@mascotassearch']);
    $router->put('/mascotas-cita/{id}', ['uses' => 'MascotasController@mascotasupdate']);
    $router->delete('/mascotas-cita/{id}', ['uses' => 'MascotasController@mascotasdelete']);
});
