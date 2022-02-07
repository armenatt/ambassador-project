<?php

use Illuminate\Http\Request;
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
function common(string $role)
{
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

    Route::middleware(['auth:api', "roles:{$role}"])->group(function () {
        Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
        Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

        Route::get('/ambassadors', [\App\Http\Controllers\AmbassadorController::class, 'index']);
        Route::get('/users/{id}/links', [\App\Http\Controllers\LinkController::class, 'index']);
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);

    });
}


// Admin
Route::prefix('admin')->group(function () {
    common('admin');

    Route::middleware(['auth:api', 'roles:admin'])->group(function () {
        Route::get('/ambassadors', [\App\Http\Controllers\AmbassadorController::class, 'index']);
        Route::get('/users/{id}/links', [\App\Http\Controllers\LinkController::class, 'index']);
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);


        Route::apiResource('products', \App\Http\Controllers\ProductController::class);
    });
});
// Ambassador
Route::prefix('/ambassador')->group(function () {
    common('ambassador');

    Route::get('products/frontend', [\App\Http\Controllers\ProductController::class, 'frontend']);
    Route::get('products/backend', [\App\Http\Controllers\ProductController::class, 'backend']);

});
//Checkout
