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

$router->group(['middleware' => 'auth:api', 'prefix' => 'api', 'as' => 'api.'], function () use ($router) {
    $router->group(['prefix' => 'transactions', 'as' => 'transactions.'], function () use ($router) {
        $router->post('/', [
            'middleware' => 'can:personal',
            'as' => 'store',
            'uses' => 'TransactionController@store'
        ]);
    });
});
