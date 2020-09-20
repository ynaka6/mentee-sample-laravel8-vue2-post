<?php

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

Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'handle']);
Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'handle']);
Route::get('posts', [\App\Http\Controllers\Api\PostController::class, 'index']);
Route::group(['middleware' => 'auth'], function () {
    Route::delete('logout', [\App\Http\Controllers\Api\Auth\LogoutController::class, 'handle']);
    Route::post('post', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::delete('post/{post}', [\App\Http\Controllers\Api\PostController::class, 'delete'])->middleware('can:delete,post');
});
