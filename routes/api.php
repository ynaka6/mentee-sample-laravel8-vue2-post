<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Post;
use App\Http\Controllers\Api\ExternalController;

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

Route::post('register', [Auth\RegisterController::class, 'handle']);
Route::post('login', [Auth\LoginController::class, 'handle']);
Route::get('posts', [PostController::class, 'index']);
Route::get('post/{post}', [PostController::class, 'show']);

Route::group(['middleware' => 'auth'], function () {
    Route::delete('logout', [Auth\LogoutController::class, 'handle']);
    Route::post('post', [PostController::class, 'store']);
    Route::delete('post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');

    Route::post('post/{post}/like', [Post\LikeController::class, 'like']);
    Route::delete('post/{post}/unlike', [Post\LikeController::class, 'unlike']);

    Route::get('external/crawler', [ExternalController::class, 'crawler']);
});
