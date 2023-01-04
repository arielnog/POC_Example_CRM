<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/users/store', [UserController::class, 'store']);

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class,'logout']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'list']);
        Route::get('/{userId}', [UserController::class, 'getById']);
        Route::put('/{userId}/update', [UserController::class, 'update']);
        Route::delete('/{userId}/delete', [UserController::class, 'delete']);
    });

    Route::group(['prefix'=> 'contacts'], function (){
        Route::get('/', [ContactController::class, 'list']);
        Route::get('/{contactId}', [ContactController::class, 'getById']);
        Route::post('/store', [ContactController::class, 'store']);
        Route::put('/{contactId}/update', [ContactController::class, 'update']);
        Route::put('/{contactId}/update/pipeline', [ContactController::class, 'updatePipeline']);
        Route::delete('/{contactId}/delete', [ContactController::class, 'delete']);
    });
});

