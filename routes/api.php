<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VendorController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1/auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'v1' ,'middleware' => 'auth:sanctum'], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/vendors', [VendorController::class, 'getVendors']);
    Route::get('/vendor/{type}', [VendorController::class, 'getVendorByCategory']);
    Route::post('/vendor/create/{type}', [VendorController::class, 'createVendor']);
    Route::get('/vendor/{id}/detail/{type}', [VendorController::class, 'detailVendor']);
    Route::post('/vendor/{id}/edit/{type}', [VendorController::class, 'updateVendor']);
    Route::delete('/vendor/{id}/delete/{type}', [VendorController::class, 'deleteVendor']);
});
