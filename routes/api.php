<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\PostController;

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


Route::prefix('v1')->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('', [UserController::class, 'create']);
        Route::get('', [UserController::class, 'all']);
        Route::get('/{id}', [UserController::class, 'findById']);
    });


    Route::prefix('websites')->group(function () {
        Route::post('', [WebsiteController::class, 'create']);
        Route::get('', [WebsiteController::class, 'all']);
        Route::get('/{id}', [WebsiteController::class, 'findById']);
    });

    Route::prefix('subscribe')->group(function () {
        Route::post('', [SubscribeController::class, 'create']);
        Route::get('', [SubscribeController::class, 'all']);

    });

    Route::prefix('posts')->group(function () {
        Route::post('', [PostController::class, 'create']);
        Route::get('', [PostController::class, 'all']);

    });
});
