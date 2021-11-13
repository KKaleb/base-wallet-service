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
// $router->group(['prefix' => 'api', 'middleware' => 'auth:api'], function () use ($router) {
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'wallets/'], function () use ($router) {
        $router->get('{id}', 'WalletController@show');
        $router->get('user/{user_id}', 'WalletController@showByUser');

        $router->group(['prefix' => '{wallet_id}/transactions/'], function () use ($router) {
            $router->get('/', 'TransactionController@index');
        });
        
        $router->group(['prefix' => 'transactions/'], function () use ($router) {
            $router->get('{id}', 'TransactionController@show');
        });
    });

    $router->group(['prefix' => 'channels/'], function () use ($router) {
        $router->get('/', 'TransactionChannelController@index');
        $router->post('/', 'TransactionChannelController@create');
        $router->get('{id}', 'TransactionChannelController@show');
    });
});
