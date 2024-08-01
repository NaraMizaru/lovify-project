<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Packet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;

class PacketController extends Controller
{
    public function createPacket(Request $request)
    {
        $credential = [
            'name' => ['string', 'required'],
            'price' => ['integer', 'required'],
            'description' => ['string', 'required'],
            'venue_id' => ['nullable'],
            'catering_id' => ['nullable'],
            'decoration_id' => ['nullable'],
            'photographer_id' => ['nullable'],
            'mua_id' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $price = 0;

        if ($request->filled('venue_id')) {
            $venue = Vendor::find($request->venue_id);
            if ($venue) {
                $price += $venue->total_price;
            }
        }
        if ($request->filled('catering_id')) {
            $catering = Vendor::find($request->catering_id);
            if ($catering) {
                $price += $catering->total_price;
            }
        }
        if ($request->filled('decoration_id')) {
            $decoration = Vendor::find($request->decoration_id);
            if ($decoration) {
                $price += $decoration->total_price;
            }
        }
        if ($request->filled('photographer_id')) {
            $photographer = Vendor::find($request->photographer_id);
            if ($photographer) {
                $price += $photographer->total_price;
            }
        }
        if ($request->filled('mua_id')) {
            $mua = Vendor::find($request->mua_id);
            if ($mua) {
                $price += $mua->total_price;
            }
        }

        $discount = $price * 0.05;
        $totalPrice = $price - $discount;

        $packet = new Packet();
        $packet->name = $request->name;
        $packet->price = $totalPrice;
        $packet->description = $request->description;
        $packet->venue_id = $request->venue_id;
        $packet->catering_id = $request->catering_id;
        $packet->decoration_id = $request->decoration_id;
        $packet->photographer_id = $request->photographer_id;
        $packet->mua_id = $request->mua_id;

        $packet->save();

        return redirect()->route('');
    }

    public function deletePacket(Packet $packet)
    {
        $packet->delete();
        return redirect()->route('');
    }

    public function detailPacket(Packet $packet)
    {
        return view('', compact('packet'));
    }

    public function allPackets()
    {
        $packets = Packet::all();
        return view('', compact('packets'));
    }
}
