<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\UserRoleMiddleware;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\ManagerRoleMiddleware;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorAuth;

/**
 * User`s routes
 */
Route::prefix('users')->group(function() {
    Route::get('', [UserController::class, 'getUsers']);
    Route::get('/{user}', [UserController::class, 'getUser']);
    Route::post('', [UserController::class, 'createUser']);
    Route::patch('/update', [UserController::class, 'updateUser']);
    Route::delete('/delete/{user}', [UserController::class, 'deleteUser']);

    Route::get('/check_role/{user}', [UserController::class, 'checkRole']);

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
 * Media`s routes
 */
Route::prefix('media')->group(function() {
    Route::get('/users/{model}', [UserController::class, 'getMedia']);
    Route::get('/dishes/{model}', [DishesController::class, 'getMedia']);

    Route::post('/users/{model}', [UserController::class, 'createMedia']);
    Route::post('/dishes/{model}', [DishesController::class, 'createMedia']);

    Route::delete('/delete/{media}', [MediaController::class, 'deleteMedia']);


});

/**
 *  Product`s routes
 */
Route::prefix('products')->group(function() {
    Route::get('', [ProductController::class, 'getProducts']);
    Route::get('/{product}', [ProductController::class, 'getProduct']);
    Route::post('', [ProductController::class, 'createProduct']);
    Route::patch('/update/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/delete/{product}', [ProductController::class, 'deleteProduct']);
});

/**
 * Restaurant`s routes
 */
Route::prefix('restaurants')->group(function() {
    Route::get('', [RestaurantController::class, 'getRestaurants']);
    Route::post('', [RestaurantController::class, 'createRestaurant']);

    Route::get('/nearestRestaurant', [RestaurantController::class, 'getNearestRestaurant']);

    Route::patch('/update/{restaurant}', [RestaurantController::class, 'updateRestaurant']);
    Route::delete('/delete/{restaurant}', [RestaurantController::class, 'deleteRestaurant']);
});

/**
 * Menu`s routes
 */
Route::prefix('menu')->group(function() {
    Route::get('', [MenuController::class, 'getAllMenu']);
    Route::get('/{menu}', [MenuController::class, 'getMenu']);
    Route::patch('/update/{menu}', [MenuController::class, 'updateMenu']);
    Route::prefix('/restaurant')->group(function() {
        Route::prefix('/{restaurant}')->group(function() {
            Route::post('', [MenuController::class, 'createMenu']);
        });
    });
    Route::delete('/delete/{menu}', [MenuController::class, 'deleteMenu']);
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
    Route::get('check_role', 'checkRole');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::patch('/change_password', [ProfileController::class, 'changePassword'])->middleware(UserRoleMiddleware::class);
});

/**
 * Payment order route
 */
Route::post('/payment/{order}', [StripePaymentController::class, 'stripePost']);

/**
 * Password recovering route
 */
Route::post('/reset/password/email', [ProfileController::class, 'sendResetLinkEmail']);
Route::post('/reset/password', [ProfileController::class, 'resetPassword']);

Route::get('/generate-2fa-secret', [TwoFactorAuth::class, 'generate2FASecret']);
Route::post('/verify-2fa-code', [TwoFactorAuth::class, 'verify2FACode']);
Route::delete('/delete-2fa-code', [TwoFactorAuth::class, 'delete2FACode']);
