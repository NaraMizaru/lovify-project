<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manage\VendorController;
use App\Http\Controllers\Manage\WeddingController;
use App\Http\Controllers\ViewController;
use App\Models\Category;
use App\Models\Packet;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/wedding/choose/{type}', function ($type, Request $request) {
//     if ($type == 'Packet') {
//         $packets = Packet::all();
//         return view('Users.addWedding', compact('type', 'packets'));
//     } else if ($type == 'Custom') {
//         $categories = Category::all();
//         $vendors = Vendor::all();
//         $attachments = VendorAttachment::all()->groupBy('vendor_id');
//         $changeCategoryId = $request->query('change_category');
//         if ($changeCategoryId) {
//             session()->forget("chosen_vendor.$changeCategoryId");
//         }
//         return view('Users.addWedding', compact('type', 'categories', 'vendors', 'attachments'));
//     }
// })->name('wedding.choose');

// Route::get('/vendor/{id}', function ($id) {
//     $vendor = Vendor::findOrFail($id);
//     $attachments = VendorAttachment::where('vendor_id', $id)->get();
//     return view('Users.vendorDetail', compact('vendor', 'attachments'));
// })->name('vendor.detail');

// Route::get('/transaction', function () {
//     return view('Users.transaction');
// })->name('transaction');

// Route::get('/history', function () {
//     return view('Users.history');
// })->name('history');

Route::get('/developers', [ViewController::class, 'developers']);

Route::middleware('is_guest')->group(function () {
    Route::get('/login', [ViewController::class, 'login'])->name('login');
    Route::get('/register', [ViewController::class,'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('is_client_or_admin');

Route::prefix('/client')->middleware('is_client')->group(function () {
    Route::get('/home', [ViewController::class, 'clientHome'])->name('client.home');
    Route::get('/profile', [ViewController::class, 'profile'])->name('client.profile');
    Route::get('/weddings', [ViewController::class, 'weddingsClient'])->name('client.weddings');
    Route::get('/transactions', [ViewController::class, 'transactionsClient'])->name('client.transactions');
    Route::get('/history', [ViewController::class, 'historyClient'])->name('client.history');
    Route::prefix('/wedding')->group(function () {
        Route::get('/add', [ViewController::class, 'addWedding'])->name('add.wedding');
        Route::post('/add', [WeddingController::class, 'addWedding'])->name('add.post.wedding');
        Route::prefix('/choose')->group(function () {
            Route::get('/packets/{wedding}', [ViewController::class, 'choosePacket'])->name('choose.packet.wedding');
            Route::get('/packets/detail/{wedding}/{packet}', [ViewController::class, 'chooseDetailPacket'])->name('choose.detail.packet.wedding');
            Route::get('/custom/{wedding}/{custom}', [ViewController::class, 'chooseCustom'])->name('choose.custom.wedding');
            Route::get('/custom/detail/{wedding}/{custom}/{vendor}', [ViewController::class, 'chooseDetailCustom'])->name('choose.detail.custom.wedding');
        });
        Route::prefix('/select')->group(function () {
            Route::get('/packets/{$wedding}/{packet}', [ViewController::class, 'selectPacket'])->name('select.packet.wedding');
        });
    });
});

Route::middleware('is_guest_or_client')->group(function () {
    Route::get('/', [ViewController::class, 'landingPage'])->name('landingPage');
    Route::get('/packets', [ViewController::class, 'packets'])->name('packets');
    Route::get('/vendors', [ViewController::class, 'vendors'])->name('vendors');

    Route::get('/vendor/details/{vendor}', [ViewController::class,'vendorDetails'])->name('vendor.detail');
});

Route::prefix('admin')->middleware('is_admin')->group(function () {
    Route::get('/home', [ViewController::class, 'adminHome'])->name('admin.home');
    Route::get('/weddings', [ViewController::class, 'weddingAdmin'])->name('weddings.admin');
    Route::get('/vendors', [ViewController::class, 'vendorAdmin'])->name('vendors.admin');
    Route::get('/vendor/details/{vendor}', [ViewController::class, 'vendorAdminDetails'])->name('vendor.admin.details');
});

Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');
Route::delete('/vendor-delete/{vendor}', [VendorController::class, 'deleteVendor'])->name('vendor.delete');
