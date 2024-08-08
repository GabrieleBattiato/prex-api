<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GifController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->prefix('gif')->name('gif.')->group(function(){
    Route::get('/{id}', [GifController::class, 'showGif'])->name('show');
    Route::get('/search/{text}/{limit?}/{offset?}', [GifController::class, 'searchGif'])->name('search');
    Route::post('/store-user-favorite', [UserController::class, 'storeUserFavoriteGif'])->name('store.favorite');
});
