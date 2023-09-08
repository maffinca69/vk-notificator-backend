<?php

/** @var Router $router */

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

use App\Http\Middleware\LoggerMiddleware;
use Laravel\Lumen\Routing\Router;

$router->group(['middleware' => LoggerMiddleware::class], static function(Router $router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->post('telegram-webhook', 'TelegramWebhookController@process');
    $router->get('vk-oauth-callback', 'VKOAuthCallbackController@callback');
    $router->post('vk-oauth-callback', 'VKOAuthCallbackController@callback');
});

