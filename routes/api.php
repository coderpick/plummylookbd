<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FrontController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->prefix('v1')->group(function (){
    Route::get('/test', function () {
        return response()->json([
            'status' => 'success',
        ]);
    });
});

Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('register', 'register')->middleware('checkAPI');
    Route::post('login', 'login')->middleware('checkAPI');
    Route::get('get-user-info', 'user_info');
    Route::post('profile-update', 'profile_update');
    Route::post('logout', 'logout');
});

Route::middleware('api')->prefix('v1')->group(function (){
    Route::get('sliders', [FrontController::class, 'slider']);
    Route::get('shop-products', [FrontController::class, 'products']);
    Route::get('sale', [FrontController::class, 'sale']);
    Route::get('product-details/{slug}', [FrontController::class, 'details']);
    Route::get('contact-info', [FrontController::class, 'contact']);
    Route::get('get-district', [FrontController::class, 'district']);
});
Route::middleware('api')->prefix('v1')->group(function (){
    Route::get('my-orders', [CustomerController::class, 'orders']);
    Route::get('my-orders/details/{id}', [CustomerController::class, 'myorder_details']);
});
