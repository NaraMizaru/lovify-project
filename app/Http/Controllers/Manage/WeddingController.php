<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Packet;
use App\Models\PacketCustom;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WeddingController extends Controller
{
    public function createWedding(Request $request, $type)
    {
        $credential = [
            'name' => ['required', 'string'],
            'date' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $user = Auth::user();

        $wedding = new Wedding();
        $wedding->name = $request->name;
        $wedding->date = $request->date;
        $wedding->user_id = $user->id;
        $wedding->save();

        return redirect()->route('', $wedding);
    }

    public function updateWedding(Request $request, $type, $wedding) {
        $credential = [
            'name' => ['required','string'],
            'date' => ['required','string'],
        ];

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $wedding->name = $request->name;
        $wedding->date = $request->date;
        $wedding->save();

        return redirect()->route('', $wedding);
    }

    public function choosePacket($type, Wedding $wedding)
    {
        if ($type == 'Packet') {
            $packets = Packet::all();
            return view('', compact('wedding', 'packets'));
        } else if ($type == 'Custom') {
            $categories = Category::all();
            $vendors = Vendor::all();
            $attachments = VendorAttachment::all()->groupBy('vendor_id');
            $custom = new PacketCustom();
            return view('', compact('wedding', 'categories', 'vendors', 'attachments', 'custom'));
        }
    }

    public function chooseDetailPacket(Wedding $wedding, Packet $packet)
    {
        return view('', compact('packet', 'wedding'));
    }

    public function selectPacket(Wedding $wedding, Packet $packet)
    {
        $wedding->packet_id = $packet->id;
        $wedding->save();
        return redirect()->route('', $wedding);
    }
}
