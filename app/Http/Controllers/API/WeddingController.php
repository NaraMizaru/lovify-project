<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Packet;
use App\Models\PacketCustom;
use App\Models\Vendor;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingController extends Controller
{
    public function createWedding(Request $request, $type)
    {
        $rules = [
            'name' => 'required',
            'date' => 'required|date'
        ];

        if (!in_array($type, ['packet', 'custom'])) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        if ($type === 'packet') {
            $rules['packet_id'] = 'required';
        } else if ($type === 'custom') {
            $rules['venue_id'] = 'nullable';
            $rules['catering_id'] = 'nullable';
            $rules['decoration_id'] = 'nullable';
            $rules['photographer_id'] = 'nullable';
            $rules['mua_id'] = 'nullable';
        }

        $user = $request->user();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 400);
        }

        $wedding = new Wedding();
        $wedding->name = $request->name;
        $wedding->date = $request->date;
        if ($type === 'packet') {
            $packet = Packet::find($request->packet_id);
            if (!$packet) {
                return response()->json([
                    'message' => 'Packet not found'
                ], 404);
            }
            $wedding->packet_id = $request->packet_id;
            $wedding->price = $packet->price;
        } else if ($type === 'custom') {
            $venue = Vendor::where('id', $request->venue_id)->first();
            $catering = Vendor::where('id', $request->catering_id)->first();
            $decoration = Vendor::where('id', $request->decoration_id)->first();
            $photographer = Vendor::where('id', $request->photographer_id)->first();
            $mua = Vendor::where('id', $request->mua_id)->first();

            $cateringPrice = $catering->total_price ?? 0;
            $decorationPrice = $decoration->total_price ?? 0;
            $muaPrice = $mua->total_price ?? 0;
            $photographerPrice = $photographer->total_price ?? 0;
            $venuePrice = $venue->total_price ?? 00;

            $totalPrice = $cateringPrice + $photographerPrice + $venuePrice + $muaPrice + $decorationPrice;

            // if (!$venue || !$catering || !$decoration || !$photographer || !$mua) {
            //     return response()->json([
            //         'message' => 'Vendor not found'
            //     ], 404);
            // }

            $custom = new PacketCustom();
            $custom->venue_id = $request->venue_id;
            $custom->catering_id = $request->catering_id;
            $custom->decoration_id = $request->decoration_id;
            $custom->photographer_id = $request->photographer_id;
            $custom->mua_id = $request->mua_id;
            $custom->save();

            if ($custom->save()) {
                $wedding->packet_custom_id = $custom->id;
                $wedding->price = $totalPrice;
            }
        }
        $wedding->user_id = $user->id;
        $wedding->save();

        return response()->json([
            'message' => 'Wedding created successfully'
        ], 201);
    }

    public function updateWedding(Request $request, $id, $type)
    {
        $rules = [
            'name' => 'required',
            'date' => 'required|date'
        ];

        if (!in_array($type, ['packet', 'custom'])) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        if ($type === 'packet') {
            $rules['packet_id'] = 'required';
        } else if ($type === 'custom') {
            $rules['venue_id'] = 'nullable';
            $rules['catering_id'] = 'nullable';
            $rules['decoration_id'] = 'nullable';
            $rules['photographer_id'] = 'nullable';
            $rules['mua_id'] = 'nullable';
        }

        $user = $request->user();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 400);
        }

        $wedding = Wedding::find($id);
        if (!$wedding) {
            return response()->json([
                'message' => 'Wedding not found'
            ], 404);
        }

        $wedding->name = $request->name;
        $wedding->date = $request->date;
        if ($type === 'packet') {
            $packet = Packet::find($request->packet_id);
            if (!$packet) {
                return response()->json([
                    'message' => 'Packet not found'
                ], 404);
            }
            $wedding->packet_id = $request->packet_id;
            $wedding->price = $packet->price;
        } else if ($type === 'custom') {
            $venue = Vendor::where('id', $request->venue_id)->first();
            $catering = Vendor::where('id', $request->catering_id)->first();
            $decoration = Vendor::where('id', $request->decoration_id)->first();
            $photographer = Vendor::where('id', $request->photographer_id)->first();
            $mua = Vendor::where('id', $request->mua_id)->first();

            $cateringPrice = $catering->total_price ?? 0;
            $decorationPrice = $decoration->total_price ?? 0;
            $muaPrice = $mua->total_price ?? 0;
            $photographerPrice = $photographer->total_price ?? 0;
            $venuePrice = $venue->total_price ?? 0;

            $totalPrice = $cateringPrice + $photographerPrice + $venuePrice + $muaPrice + $decorationPrice;

            // if (!$venue || !$catering || !$decoration || !$photographer || !$mua) {
            //     return response()->json([
            //         'message' => 'Vendor not found'
            //     ], 404);
            // }

            $custom = PacketCustom::find($wedding->packet_custom_id);
            if (!$custom) {
                $custom = new PacketCustom();
            }
            $custom->venue_id = $request->venue_id;
            $custom->catering_id = $request->catering_id;
            $custom->decoration_id = $request->decoration_id;
            $custom->photographer_id = $request->photographer_id;
            $custom->mua_id = $request->mua_id;
            $custom->save();

            $wedding->packet_custom_id = $custom->id;
            $wedding->price = $totalPrice;
        }
        $wedding->user_id = $user->id;
        $wedding->save();

        return response()->json([
            'message' => 'Wedding updated successfully'
        ], 200);
    }

    public function getDetailWedding($id)
    {
        $wedding = Wedding::where('id', $id)->with([
            'packet.venue.vendorAttachment',
            'packet.decoration.vendorAttachment',
            'packet.catering.vendorAttachment',
            'packet.photographer.vendorAttachment',
            'packet.mua.vendorAttachment',
            'packetCustom.venue.vendorAttachment',
            'packetCustom.decoration.vendorAttachment',
            'packetCustom.catering.vendorAttachment',
            'packetCustom.photographer.vendorAttachment',
            'packetCustom.mua.vendorAttachment',
        ])->first();

        if (!$wedding) {
            return response()->json([
                'message' => 'Wedding not found'
            ], 404);
        }

        if ($wedding->packet_id !== NULL) {
            if ($wedding->packet->venue || $wedding->packet->decoration || $wedding->packet->photographer || $wedding->packet->mua || $wedding->packet->catering) {
                $wedding->packet->venue->makeHidden(
                    'qty',
                    'created_at',
                    'updated_at',
                );

                $wedding->packet->decoration->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packet->photographer->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packet->mua->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packet->catering->makeHidden([
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }
        } else if ($wedding->packet_custom_id !== NULL) {
            if ($wedding->packetCustom->venue || $wedding->packetCustom->decoration || $wedding->packetCustom->photographer || $wedding->packetCustom->mua || $wedding->packetCustom->catering) {
                $wedding->packetCustom->venue->makeHidden(
                    'qty',
                    'created_at',
                    'updated_at',
                );

                $wedding->packetCustom->decoration->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packetCustom->photographer->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packetCustom->mua->makeHidden([
                    'qty',
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);

                $wedding->packetCustom->catering->makeHidden([
                    'address',
                    'total_guest',
                    'created_at',
                    'updated_at',
                ]);
            }
        }

        return response()->json([
            'message' => 'Get detail wedding',
            'wedding' => $wedding
        ], 200);
    }

    public function getWeddingByCategory($type)
    {
        if (!in_array($type, ['packet', 'custom'])) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        if ($type === 'packet') {
            $wedding = Wedding::where('packet_id', '!=', NULL)->with([
                'packet.venue.vendorAttachment'
            ])->get();

            return response()->json([
                'message' => 'Get wedding packet',
                'weddings' => $wedding
            ], 200);
        } else if ($type === 'custom') {
            $wedding = Wedding::where('packet_custom_id', '!=', NULL)->with([
                'packetCustom.venue.vendorAttachment'
            ])->get();

            return response()->json([
                'message' => 'Get wedding custom',
                'weddings' => $wedding
            ], 200);
        }
    }

    public function getWeddings()
    {
        $weddings = Wedding::with([
            'packet.venue.vendorAttachment',
            'packet.decoration.vendorAttachment',
            'packet.catering.vendorAttachment',
            'packet.photographer.vendorAttachment',
            'packet.mua.vendorAttachment',
            'packetCustom.venue.vendorAttachment',
            'packetCustom.decoration.vendorAttachment',
            'packetCustom.catering.vendorAttachment',
            'packetCustom.photographer.vendorAttachment',
            'packetCustom.mua.vendorAttachment',
        ])->get();

        foreach ($weddings as $wedding) {
            if ($wedding->packet) {
                if ($wedding->packet->venue) {
                    $wedding->packet->venue->makeHidden([
                        'qty',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packet->decoration) {
                    $wedding->packet->decoration->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packet->photographer) {
                    $wedding->packet->photographer->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packet->mua) {
                    $wedding->packet->mua->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packet->catering) {
                    $wedding->packet->catering->makeHidden([
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }
            }

            if ($wedding->packetCustom) {
                if ($wedding->packetCustom->venue) {
                    $wedding->packetCustom->venue->makeHidden([
                        'qty',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packetCustom->decoration) {
                    $wedding->packetCustom->decoration->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packetCustom->photographer) {
                    $wedding->packetCustom->photographer->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packetCustom->mua) {
                    $wedding->packetCustom->mua->makeHidden([
                        'qty',
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }

                if ($wedding->packetCustom->catering) {
                    $wedding->packetCustom->catering->makeHidden([
                        'address',
                        'total_guest',
                        'created_at',
                        'updated_at',
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Get wedding',
            'weddings' => $weddings
        ], 200);
    }
}
