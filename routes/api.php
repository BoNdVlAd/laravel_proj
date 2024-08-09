<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\UserRoleMiddleware;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\ManagerRoleMiddleware;

/**
 * User`s routes
 */
Route::prefix('users')->group(function() {
    Route::get('', [UserController::class, 'getUsers']);
    Route::get('/{user}', [UserController::class, 'getUser']);
    Route::post('', [UserController::class, 'createUser']);
    Route::patch('/update/{user}', [UserController::class, 'updateUser']);
    Route::delete('/delete/{user}', [UserController::class, 'deleteUser']);

    Route::get('/manager/{user}', [UserController::class, 'checkManager'])->middleware(UserRoleMiddleware::class);;
    Route::get('/waiter/{user}', [UserController::class, 'checkWaiter'])->middleware(UserRoleMiddleware::class);
    Route::get('/chef/{user}', [UserController::class, 'checkChef'])->middleware(UserRoleMiddleware::class);
    Route::get('/customer/{user}', [UserController::class, 'checkCustomer'])->middleware(UserRoleMiddleware::class);

    Route::patch('/role_manager', [UserController::class, 'editRoleToManager']);
    Route::patch('/role_waiter', [UserController::class, 'editRoleToWaiter']);
    Route::patch('/role_chef', [UserController::class, 'editRoleToChef']);
    Route::patch('/role_customer', [UserController::class, 'editRoleToCustomer']);
});

/**
 * Order`s routes
 */
Route::prefix('orders')->group(function() {
    Route::get('', [OrderController::class, 'getOrders'])->middleware(ManagerRoleMiddleware::class);
    Route::get('/{order}', [OrderController::class, 'getOrder']);
    Route::post('', [OrderController::class, 'createOrder'])->middleware(UserRoleMiddleware::class);
    Route::patch('/update/{order}', [OrderController::class, 'updateOrder'])->middleware(UserRoleMiddleware::class);
    Route::delete('/delete/{order}', [OrderController::class, 'deleteOrder'])->middleware(UserRoleMiddleware::class);
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

    Route::post('/addDishToOrder/{order}', [DishesController::class, 'addDishToOrder']);
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

/**
 * Handle wrong sub url
 */
Route::any('{url?}/{sub_url?}', function() {
    return response()->json([
        "message" => "Page not found"
    ], 404);
});

