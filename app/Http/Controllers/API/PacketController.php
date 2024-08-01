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

        if (!$venue || !$decoration || !$photographer || !$catering || !$mua) {
            return response()->json([
                'message' => 'Invalid vendor ID'
            ], 400);
        }

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

    public function deletePacket(Request $request, $id)
    {
        $packet = Packet::find($id);

        if (!$packet) {
            return response()->json([
                'message' => 'Packet not found'
            ], 404);
        }

        $user = $request->user();
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to delete packet'
            ], 403);
        }

        $packet->delete();
        return response()->json([
            'message' => 'Packet deleted successfully'
        ], 200);
    }

    public function getDetailPacket($id)
    {
        $packet = Packet::with([
            'venue.vendorAttachment',
            'decoration.vendorAttachment',
            'catering.vendorAttachment',
            'photographer.vendorAttachment',
            'mua.vendorAttachment',
            'rating'
        ])->find($id);

        if ($packet->venue || $packet->decoration || $packet->photographer || $packet->mua || $packet->catering) {
            $packet->venue->makeHidden(
                'qty',
                'created_at',
                'updated_at',
            );

            $packet->decoration->makeHidden([
                'qty',
                'address',
                'total_guest',
                'created_at',
                'updated_at',
            ]);

            $packet->photographer->makeHidden([
                'qty',
                'address',
                'total_guest',
                'created_at',
                'updated_at',
            ]);

            $packet->mua->makeHidden([
                'qty',
                'address',
                'total_guest',
                'created_at',
                'updated_at',
            ]);

            $packet->catering->makeHidden([
                'address',
                'total_guest',
                'created_at',
                'updated_at',
            ]);
        }

        if (!$packet) {
            return response()->json([
                'message' => 'Packet not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Get detail packet',
            'packet' => $packet
        ], 200);
    }

    public function getPackets()
    {
        $packets = Packet::with([
            'venue.vendorAttachment',
            'decoration.vendorAttachment',
            'catering.vendorAttachment',
            'photographer.vendorAttachment',
            'mua.vendorAttachment',
            'rating'
        ])->get();

        foreach ($packets as $packet) {
            if ($packet->venue) {
                $packet->venue->makeHidden([
                    'qty',
                    'created_at',
                    'updated_at',
                ]);
            }

            if ($packet->decoration) {
                $packet->decoration->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }

            if ($packet->photographer) {
                $packet->photographer->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }

            if ($packet->mua) {
                $packet->mua->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }

            if ($packet->catering) {
                $packet->catering->makeHidden([
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }
        }

        return response()->json([
            'message' => 'Get packets',
            'data' => $packets
        ], 200);
    }
}
