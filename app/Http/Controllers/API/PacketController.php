<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Packet;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacketController extends Controller
{
    public function createPacket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'venue_id' => 'required',
            'catering_id' => 'required',
            'decoration_id' => 'required',
            'photographer_id' => 'required',
            'mua_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'error' => $validator->errors()
            ], 400);
        }

        $user = $request->user();
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to create packet'
            ], 403);
        }

        $venue = Vendor::where('id', $request->venue_id)->first();
        $decoration = Vendor::where('id', $request->decoration_id)->first();
        $photographer = Vendor::where('id', $request->photographer_id)->first();
        $catering = Vendor::where('id', $request->catering_id)->first();
        $mua = Vendor::where('id', $request->mua_id)->first();

        $cateringPrice = $catering->total_price * $

        $price = $venue->total_price + $decoration->total_price + $catering->total_price + $mua->total_price  + $photographer->total_price;
        $discount = $price * 0.05;

        $totalPrice = $price - $discount;

        $packet = new Packet();
        $packet->name = $request->name;
        $packet->description = $request->description;
        $packet->price = $totalPrice;
        $packet->venue_id = $request->venue_id;
        $packet->catering_id = $request->catering_id;
        $packet->decoration_id = $request->decoration_id;
        $packet->photographer_id = $request->photographer_id;
        $packet->mua_id = $request->mua_id;
        $packet->save();

        return response()->json([
            'message' => 'Packet created successfully'
        ], 201);
    }
}
