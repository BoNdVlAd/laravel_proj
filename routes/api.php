<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\UserRoleMiddleware;

/**
 * User`s routes
 */
Route::prefix('users')->group(function() {
    Route::get('', [UserController::class, 'getUsers']);
    Route::get('/{user}', [UserController::class, 'getUser']);
    Route::post('', [UserController::class, 'createUser']);
    Route::patch('/update/{user}', [UserController::class, 'updateUser']);
    Route::delete('/delete/{user}', [UserController::class, 'deleteUser']);
});

/**
 * Dishes`s routes
 */
Route::prefix('dishes')->group(function() {
    Route::get('', [DishesController::class, 'getDishes']);
    Route::get('/{dishes}', [DishesController::class, 'getDish']);
    Route::post('', [DishesController::class, 'createDish']);
    Route::patch('/update/{dishes}', [DishesController::class, 'updateDish']);
    Route::delete('/delete/{dishes}', [DishesController::class, 'deleteDish']);
});
/**
 * Invoke`s routes
 */
Route::get('/test', TestController::class);

/**
 * Auth`s routes
 */
Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('me', 'me')->middleware(UserRoleMiddleware::class);
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::any('{url?}/{sub_url?}', function() {
    return response()->json([
        "message" => "Page not found"
    ], 404);
});

