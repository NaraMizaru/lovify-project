<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manage\VendorController;
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

Route::get('/', function () {
    $categories = Category::all();
    $vendors = Vendor::all();
    $attachments = VendorAttachment::all()->groupBy('vendor_id');
    return view('Users.home', compact('categories', 'vendors', 'attachments'));
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/landingpage', function () {
    return view('Users.landingpage');
})->name('landingpage');

Route::get('/packets', function () {
    return view('Users.packets');
})->name('packets');

Route::get('/profile', function () {
    return view('Users.profile');
})->name('profile');

Route::get('/wedding', function () {
    $weddings = Wedding::where('user_id', Auth::user()->id)->get();
    return view('Users.wedding', compact('weddings'));
})->name('wedding');

Route::get('/add.wedding', function () {
    return view('Users.choosePacketOrCustom');
})->name('add.wedding');

Route::get('/wedding/choose/{type}', function ($type, Request $request) {
    if ($type == 'Packet') {
        $packets = Packet::all();
        return view('Users.addWedding', compact('type', 'packets'));
    } else if ($type == 'Custom') {
        $categories = Category::all();
        $vendors = Vendor::all();
        $attachments = VendorAttachment::all()->groupBy('vendor_id');
        $changeCategoryId = $request->query('change_category');
        if ($changeCategoryId) {
            session()->forget("chosen_vendor.$changeCategoryId");
        }
        return view('Users.addWedding', compact('type', 'categories', 'vendors', 'attachments'));
    }
})->name('wedding.choose');

Route::get('/vendor/{id}', function ($id) {
    $vendor = Vendor::findOrFail($id);
    $attachments = VendorAttachment::where('vendor_id', $id)->get();
    return view('Users.vendorDetail', compact('vendor', 'attachments'));
})->name('vendor.detail');

Route::get('/transaction', function () {
    return view('Users.transaction');
})->name('transaction');

Route::get('/history', function () {
    return view('Users.history');
})->name('history');

Route::get('/vendor', function () {
    return view('Users.vendor');
})->name('vendor');

Route::get('/developer', function () {
    return view('Users.developer');
})->name('developer');

Route::get('/dashboard-admin', function () {
    return view('admin.dashboard-admin');
})->name('dashboard-admin');

Route::get('/wedding-admin', function () {
    $weddings = Wedding::all();
    return view('admin.wedding', compact('weddings'));
})->name('wedding-admin');

Route::get('/vendor-admin', function () {
    $vendors = Vendor::all();
    $categories = Category::all();
    return view('admin.vendor', compact('vendors'));
})->name('vendor-admin');

Route::get('/vendor-detail/{vendor}', function (Vendor $vendor) {
    return view('admin.vendorDetail', compact('vendor'));
})->name('vendor.detail');

Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');
Route::delete('/vendor-delete/{vendor}', [VendorController::class, 'deleteVendor'])->name('vendor.delete');
