<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request, $type)
    {
        $category = Category::where('name', $type)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'fee' => 'required|integer',
            'bank_number' => 'required|string',
            'number_phone' => 'required|string',
            'attachments.*' => 'required|file|mimes:png,jpg,jpeg'
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
        $vendor->price = $request->price;
        $vendor->fee = $request->fee;
        $vendor->total_price = $request->price + $request->fee;
        $vendor->bank_number = $request->bank_number;
        $vendor->number_phone = $request->number_phone;
        if ($type == 'venue') {
            $vendor->address = $request->address;
            $vendor->total_guest = $request->total_guest;
        }
        $vendor->category_id = $category->id;

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $attachmentName = time() . '.' . $attachment->getClientOriginalExtension();

                $vendorAttachment = new VendorAttachment();
                $vendorAttachment->image_path = $attachment->storeAs('vendor/' . $category->name, $attachmentName);

                if (!$vendor->exists) {
                    $vendor->save();
                }

                $vendorAttachment->vendor_id = $vendor->id;
                $vendorAttachment->save();
            }

            return response()->json([
                'message' => 'Vendor created successfully',
            ], 201);
        }
    }
}
