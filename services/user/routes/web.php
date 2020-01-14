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
    $router->post('/user', '\User\Core\Infrastructure\Delivery\Api\Controller\UserController@registerCustomer');
    $router->get('/user/{userId}', '\User\Core\Infrastructure\Delivery\Api\Controller\UserController@getUserById');
});

$router->group(['prefix' => 'rpc', 'middleware' => ['auth.rpc']], function () use ($router) {
    $router->get('/user/{userId}', '\User\Core\Infrastructure\Delivery\Rpc\Controller\UserController@getUserById');
});
