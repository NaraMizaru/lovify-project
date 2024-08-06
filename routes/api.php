<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PacketController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\WeddingController;
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

Route::prefix('v1')->group(function() {
    Route::get('/packets', [PacketController::class, 'getPackets']);
    Route::get('/detail/{id}/packet', [PacketController::class, 'getDetailPacket']);

});

Route::group(['prefix' => 'v1' ,'middleware' => 'auth:sanctum'], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/vendors', [VendorController::class, 'getVendors']);
    Route::get('/vendors/{type}', [VendorController::class, 'getVendorByCategory']);
    Route::get('/vendor/{id}/detail/{type}', [VendorController::class, 'detailVendor']);
    Route::post('/vendor/create/{type}', [VendorController::class, 'createVendor']);
    Route::post('/vendor/{id}/edit/{type}', [VendorController::class, 'updateVendor']);
    Route::delete('/vendor/{id}/delete/{type}', [VendorController::class, 'deleteVendor']);

    Route::get('weddings', [WeddingController::class, 'getWeddings']);
    Route::get('weddings/{type}', [WeddingController::class, 'getWeddingByCategory']);
    Route::get('wedding/{id}/detail', [WeddingController::class, 'getDetailWedding']);
    Route::post('create/wedding/{type}', [WeddingController::class, 'createWedding']);
    Route::post('update/{id}/wedding/{type}', [WeddingController::class, 'updateWedding']);
    Route::delete('wedding/{id}/delete', [WeddingController::class, 'deleteWedding']);
    
    Route::post('wedding/{id}/task/{taskName}/process', [TaskController::class, 'taskToProcess']);
    Route::post('wedding/{id}/task/{taskName}/ready', [TaskController::class, 'taskToReady']);

    Route::prefix('admin')->group(function() {
        Route::post('/create/packet', [PacketController::class, 'createPacket']);
        Route::delete('/delete/{id}/packet', [PacketController::class, 'deletePacket']);
    });
});
