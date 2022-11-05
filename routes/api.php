<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$router->group(['prefix' => 'settings'], static function ($router) {
    $router->get('/', 'SettingsController@get');
    $router->post('/update', 'SettingsController@update');
});
