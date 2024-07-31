<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request, $type)
    {
        if (!$type) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }
        $category = Category::where('name', $type)->first();
        dd($category);

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|integer',
            'fee' => 'required|integer',
            'total_price' => 'required|integer',
            'bank_number' => 'required|string',
            'number_phone' => 'required|string',
        ];

        if ($type === 'venue') {
            $rules['total_guest'] = 'required|integer';
            $rules['address'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }


        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->description = $request->description;
        $vendor->address = $request->address;
        $vendor->price = $request->price;
        $vendor->fee = $request->fee;
        $vendor->total_price = $request->price + $request->fee;
        // $vendor->category_id = ;
    }
}
