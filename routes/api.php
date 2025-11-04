<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlogController;

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

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('user', [UserController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('blog')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::get('{id}', [BlogController::class, 'show']);
    });

    Route::prefix('me/blog')->group(function () {
        Route::get('', [BlogController::class, 'myBlogs']);
        Route::post('', [BlogController::class, 'save']);
        Route::put('{id}', [BlogController::class, 'update']);
    });
});
