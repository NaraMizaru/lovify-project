<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Packet;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function developers()
    {
        return view('Users.developer');
    }

    public function landingPage()
    {
        return view('Users.landingpage');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function clientHome()
    {
        $categories = Category::all();
        $vendors = Vendor::all();
        $attachments = VendorAttachment::all()->groupBy('vendor_id');
        return view('Users.home', compact('categories', 'vendors', 'attachments'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('Users.profile', compact('user'));
    }

    public function weddingsClient()
    {
        $weddings = Wedding::where('user_id', Auth::user()->id)->get();
        return view('Users.wedding', compact('weddings'));
    }

    public function transactionsClient()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->where('status', 'process')->get();
        return view('Users.transaction', compact('transactions'));
    }

    public function historyClient()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->where('status', 'success')->get();
        return view('Users.transaction', compact('transactions'));
    }

    public function packets()
    {
        $packets = Packet::all();
        return view('Users.packets', compact('packets'));
    }

    public function vendors()
    {
        $vendors = Vendor::all();
        $attachments = VendorAttachment::all()->groupBy('vendor_id');
        $categories = Category::all();
        return view('Users.vendor', compact('vendors', 'attachments', 'categories'));
    }

    public function detailVendor(Vendor $vendor)
    {
        $attachments = VendorAttachment::where('vendor_id', $vendor->id)->get();
        return view('Users.vendorDetail', compact('vendor', 'attachments'));
    }

    public function addWedding()
    {
        return view('Users.addWedding');
    }


    // Admin
    public function adminHome()
    {
        return view('admin.dashboard-admin');
    }

    public function weddingAdmin()
    {
        $weddings = Wedding::all();
        return view('admin.wedding', compact('weddings'));
    }

    public function vendorAdmin()
    {
        $vendors = Vendor::all();
        $categories = Category::all();
        return view('admin.vendor', compact('vendors', 'categories'));
    }

    public function vendorAdminDetails(Vendor $vendor)
    {
        return view('admin.vendorDetail', compact('vendor'));
    }
}
