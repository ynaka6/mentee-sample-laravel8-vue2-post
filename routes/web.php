<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/health', function() {
    return response('ok', 200);
});
Route::any('/{any}', [\App\Http\Controllers\FrontendController::class, 'app'])
    ->where('any', '^(?!api).*$');
