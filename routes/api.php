<?php

use App\Http\Controllers\Apis\AuthenticateController;
use App\Http\Controllers\Apis\PostController;
use App\Http\Controllers\Apis\UserController;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/', [AuthenticateController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [AuthenticateController::class, 'logout']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);

    Route::get('/test-policy', [PostController::class, 'index']);

});
