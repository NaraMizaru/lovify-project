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
        ];
        
        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $venue = Vendor::find($request->venue_id);
        $catering = Vendor::find($request->catering_id);
        $decoration = Vendor::find($request->decoration_id);
        $photographer = Vendor::find($request->photographer_id);
        $mua = Vendor::find($request->mua_id);

        $price = $venue->total_price + $catering->total_price + $decoration->total_price + $photographer->total_price + $mua->total_price;
        $discount = $price * 0.05;
        $totalPrice = $price + $discount;

        $packet = new Packet();
        $packet->name = $request->name;
        $packet->price = $totalPrice;
        $packet->description = $request->description;
        $packet->venue_id = $request->venue_id;
        $packet->catering_id = $request->catering_id;
        $packet->decoration_id = $request->decoration_id;
        $packet->photographer_id = $request->photographer_id;
        $packet->mua_id = $request->mua_id;

        return redirect()->route('');
    }
}
