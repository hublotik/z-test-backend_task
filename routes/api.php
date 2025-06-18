<?php


use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return app()->version();
});

$router->group(['prefix' => 'api'], function() use ($router){

    $router->get('/', function () use ($router) {
        return 'start page';
    });

});
