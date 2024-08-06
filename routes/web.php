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
    return view('Users.wedding');
})->name('wedding');

Route::get('/transaction', function () {
    return view('Users.transaction');
})->name('transaction');

Route::get('/history', function () {
    return view('Users.history');
})->name('history');

Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');
