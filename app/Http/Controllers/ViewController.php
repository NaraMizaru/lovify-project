<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Packet;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use Illuminate\Http\Request;

class ViewController extends Controller
{
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


    // Admin
    public function adminHome()
    {
        return view('admin.dashboard-admin');
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
