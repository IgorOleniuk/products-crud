<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
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
// register user
Route::post('/register', [AuthController::class, 'register']);
// login user
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('products')->group(function () {
        // paginate list of the products
        Route::get('/', [ProductController::class, 'products']);
        // create or update product
        Route::post('/save-product', [ProductController::class, 'saveProduct']);
        // delete product
        Route::delete('/remove/{product}', [ProductController::class, 'removeProduct']);

        // purchase products
        Route::post('/purchase', [ProductController::class, 'purchase']);

        // date report
        Route::get('/date-report', [ProductController::class, 'dateReport']);
    });
});
