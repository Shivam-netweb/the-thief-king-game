<?php

use App\Events\PlaygroundEvent;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'],function(){
    # public routes
    Route::group(['module' => 'authRoutes'],function(){
        Route::post('login',[UserController::class, 'loginUser']);
        Route::post('register',[UserController::class, 'registerUser']);
        Route::post('/auth/{id}/generate-token',[UserController::class, 'generateToken']);
    });

    Route::group(['module' => 'privateRoutes','middleware' => 'auth:sanctum'], function(){
        Route::post('new-game', [UserController::class, 'startNewGame']);
    });

    Route::get('/event',function(){
        event(new PlaygroundEvent);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
