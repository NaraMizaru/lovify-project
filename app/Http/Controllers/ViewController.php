<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Packet;
use App\Models\PacketCustom;
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
        return view('Users.Wedding.wedding', compact('weddings'));
    }

    public function addWedding()
    {
        return view('Users.Wedding.addWedding');
    }

    public function choosePacket(Wedding $wedding)
    {
        $packets = Packet::all();
        return view('Users.Wedding.choosePacket', compact('wedding', 'packets'));
    }

    public function chooseDetailPacket(Wedding $wedding, Packet $packet)
    {
        return view('Users.Wedding.chooseDetailPacket', compact('wedding', 'packet'));
    }

    public function selectPacket(Wedding $wedding, Packet $packet)
    {
        $price = $packet->price;
        $dp = 0.15 * $price;
        $wedding->packet_id = $packet->id;
        $wedding->price = $price + $dp;
        $wedding->save();
        return redirect()->route('client.weddings');
    }

    public function chooseCustom(Wedding $wedding, PacketCustom $custom)
    {
        $categories = Category::all();
        $vendors = Vendor::all();
        $attachments = VendorAttachment::all()->groupBy('vendor_id');
        return view('Users.Wedding.chooseCustom', compact('wedding', 'custom', 'categories', 'vendors', 'attachments'));
    }

    public function chooseDetailCustom(Wedding $wedding, PacketCustom $custom, Vendor $vendor)
    {
        $attachments = VendorAttachment::where('vendor_id', $vendor->id)->get();
        return view('Users.Wedding.chooseDetailCustom', compact('wedding', 'custom', 'vendor', 'attachments'));
    }

    public function selectCustom(Wedding $wedding, PacketCustom $custom, Vendor $vendor, $type)
    {
        $key = "chosen_vendor.{$custom->id}.{$type}";
        if (session()->has($key)) {
            session()->forget($key);
        }
        session()->put($key, $vendor->id);
        $custom->$type = $vendor->id;
        $custom->save();
        return view('Users.Wedding.chooseCustom');
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

    public function vendorDetails(Vendor $vendor)
    {
        $attachments = VendorAttachment::where('vendor_id', $vendor->id)->get();
        return view('Users.vendorDetail', compact('vendor', 'attachments'));
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
