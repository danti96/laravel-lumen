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
    //$user = Auth::user();
    //$user = $request->user();
});
