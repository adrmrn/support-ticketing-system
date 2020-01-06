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

$router->get('/', function () use ($router) {
    return new \Illuminate\Http\JsonResponse([
        'status' => 'ok'
    ]);
});

$router->group(['prefix' => 'api', 'middleware' => ['transaction']], function () use ($router) {
    $router->post('/user', '\User\Core\Infrastructure\Delivery\Api\Controller\UserController@registerUser');
});
