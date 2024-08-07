<?php

use App\Http\Controllers\AuthController;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\VendorAttachment;
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
    $vendors = Vendor::all();
    $attachments = VendorAttachment::groupBy('vendor_id')->selectRaw('MIN(id) as id, vendor_id')->get();
    $categories = Category::all();
    return view('Users.home', compact('vendors', 'categories', 'attachments'));
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
    return view('Users.wedding');
})->name('wedding');

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
    return view('admin.wedding');
})->name('wedding-admin');

Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');
