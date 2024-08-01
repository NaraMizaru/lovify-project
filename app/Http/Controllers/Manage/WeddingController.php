<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WeddingController extends Controller
{
    public function createWedding(Request $request)
    {
        $credential = [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'packet_id' => ['nullable'],
            'packet_custom_id' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
        }

        $user = Auth::user();

        $wedding = new Wedding();
        $wedding->name = $request->name;
        $wedding->price = $request->price;
        $wedding->date = $request->date;
        $wedding->user_id = $user->id;

        if ($request->packet_id) {
            $wedding->packet_id = $request->packet_id;
        } else {
            $wedding->packet_custom_id = $request->packet_custom_id;
        }

        $wedding->save();

        return redirect()->route('');
    }

    public function updateWedding(Request $request ,Wedding $wedding)
    {
        $credential = [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'packet_id' => ['nullable'],
            'packet_custom_id' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
        }

        $wedding->name = $request->name;
        $wedding->price = $request->price;
        $wedding->date = $request->date;

        if ($request->packet_id) {
            $wedding->packet_id = $request->packet_id;
        } else {
            $wedding->packet_custom_id = $request->packet_custom_id;
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
