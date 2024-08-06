<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Packet;
use App\Models\PacketCustom;
use App\Models\Task;
use App\Models\Vendor;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WeddingController extends Controller
{
    // public function createWeddingWithPacket(Request $request)
    // {
    //     $credential = [
    //         'name' => ['required', 'string'],
    //         'price' => ['required', 'integer'],
    //         'date' => ['required', 'string'],
    //         'packet_id' => ['required'],
    //     ];

    //     $validator = Validator::make($request->all(), $credential);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
    //     }

    //     $user = Auth::user();

    //     $wedding = new Wedding();
    //     $wedding->name = $request->name;
    //     $wedding->price = $request->price;
    //     $wedding->date = $request->date;
    //     $wedding->user_id = $user->id;
    //     $wedding->packet_id = $request->packet_id;
    //     $wedding->packet_custom_id = null;

    //     $wedding->save();

    //     $tasks = new Task();

    //     return redirect()->route('');
    // }

    // public function createWeddingWithPacketCustom(Request $request)
    // {
    //     $credential = [
    //         'name' => ['required', 'string'],
    //         'price' => ['required', 'integer'],
    //         'date' => ['required', 'string'],
    //         'packet_id' => ['nullable'],
    //     ];

    //     $validator = Validator::make($request->all(), $credential);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
    //     }

    //     $packetCustom = new PacketCustom();
    //     $packetCustom->venue_id = $request->venue_id ?? null;
    //     $packetCustom->catering_id = $request->catering_id ?? null;
    //     $packetCustom->decoration_id = $request->decoration_id ?? null;
    //     $packetCustom->photographer_id = $request->photographer_id ?? null;
    //     $packetCustom->mua_id = $request->mua_id ?? null;
    //     $packetCustom->save();

    //     $user = Auth::user();

    //     $wedding = new Wedding();
    //     $wedding->name = $request->name;
    //     $wedding->price = $request->price;
    //     $wedding->date = $request->date;
    //     $wedding->user_id = $user->id;
    //     $wedding->packet_custom_id = $request->packet_custom_id;
    //     $wedding->packet_id = null;

    //     $wedding->save();

    //     return redirect()->route('');
    // }

    public function createWedding(Request $request, $type)
    {
        $credential = [
            'name' => ['required','string'],
            'date' => ['required','string'],
        ];

        if ($type == 'Packet') {
            $credential['packet_id'] = ['required'];
        } else if ($type == 'Custom') {
            $credential['venue_id'] = ['nullable'];
            $credential['catering_id'] = ['nullable'];
            $credential['decoration_id'] = ['nullable'];
            $credential['photographer_id'] = ['nullable'];
            $credential['mua_id'] = ['nullable'];
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
        }

        $wedding = new Wedding();
        $wedding->name = $request->name;        $wedding->price = $request->price;
        $wedding->date = $request->date;

        if ($type == 'Packet') {
            $packet = Packet::find($request->packet_id);
            $wedding->packet_id = $packet->id;
            $wedding->price = $packet->price;
        } else if ($type == 'Custom') {
            $venue = Vendor::find($request->venue_id)->first() ?? null;
            $catering = Vendor::find($request->catering_id)->first() ?? null;;
            $decoration = Vendor::find($request->decoration_id)->first() ?? null;;
            $mua = Vendor::find($request->mua_id)->first() ?? null;
            $photographer = Vendor::find($request->photographer_id)->first() ?? null;;

            $venuePrice = $venue->total_price ?? 0;
            $decorationPrice = $decoration->total_price ?? 0;
            $muaPrice = $mua->total_price ?? 0;
            $photographerPrice = $photographer->total_price ?? 0;
            $cateringPrice = $catering->total_price ?? 0;

            $totalPrice = $venuePrice + $decorationPrice + $muaPrice + $photographerPrice + $cateringPrice;
            dd($totalPrice);

            $custom = new PacketCustom();
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

        return redirect()->route('home');
    }

    public function updateWedding(Request $request ,Wedding $wedding = null, $type)
    {
        $credential = [
            'name' => ['required','string'],
            'date' => ['required','string'],
        ];

        if ($type == 'packet') {
            $credential['packet_id'] = ['required'];
        } else if ($type == 'custom') {
            $credential['venue_id'] = ['nullable'];
            $credential['catering_id'] = ['nullable'];
            $credential['decoration_id'] = ['nullable'];
            $credential['photographer_id'] = ['nullable'];
            $credential['mua_id'] = ['nullable'];
        }

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
        }

        $wedding->name = $request->name;
        $wedding->date = $request->date;

        if ($type == 'packet') {
            $packet = Packet::find($request->packet_id);
            $wedding->packet_id = $packet->id;
            $wedding->price = $packet->price;
        } else if ($type == 'custom') {
            $venue = Vendor::find($request->venue_id)->first();
            $catering = Vendor::find($request->catering_id)->first();
            $decoration = Vendor::find($request->decoration_id)->first();
            $mua = Vendor::find($request->mua_id)->first();
            $photographer = Vendor::find($request->photographer_id)->first();

            $venuePrice = $venue->total_price ?? 0;
            $decorationPrice = $decoration->total_price ?? 0;
            $muaPrice = $mua->total_price ?? 0;
            $photographerPrice = $photographer->total_price ?? 0;
            $cateringPrice = $catering->total_price ?? 0;

            $totalPrice = $venuePrice + $decorationPrice + $muaPrice + $photographerPrice + $cateringPrice;

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

        $wedding->save();

        return redirect()->route('');
    }

    public function deleteWedding(Wedding $wedding)
    {
        $wedding->delete();
        return redirect()->route('');
    }

    public function allWeddings()
    {
        $weddings = Wedding::all();
        return view('', compact('weddings'));
    }

    public function detailWedding(Wedding $wedding)
    {
        return view('', compact('wedding'));
    }
}
