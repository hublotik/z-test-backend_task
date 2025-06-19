<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TenderController;

$router->get('/', function () use ($router) {
    return app()->version();
});

$router->group(['prefix' => 'api'], function() use ($router){
    
    Route::middleware('auth.api')->group(function () {
        Route::apiResource('tenders', TenderController::class);
    });
    
    $router->get('/', function () use ($router) {
        return 'start page';
    });

});
