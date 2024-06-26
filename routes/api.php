<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\FavController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//public routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::resource('/property',DisplayController::class);

//Protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){

        Route::post('/logout',[AuthController::class,'logout']);
        Route::resource('/tasks',TasksController::class);
        Route::resource('/fav',FavController::class);
        Route::get('/delfav/{id}',[FavController::class,'del']);

});

