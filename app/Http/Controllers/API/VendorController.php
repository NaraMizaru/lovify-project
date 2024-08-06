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
        } else if ($type === 'catering') {
            $rules['qty'] = 'required|integer';
        }


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to create vendor'
            ], 403);
        }

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->description = $request->description;
        $vendor->price = $request->price;
        $vendor->fee = $request->fee;
        if ($type !== 'catering') {
            $vendor->total_price = $request->price + $request->fee;
        }
        $vendor->bank_number = $request->bank_number;
        $vendor->number_phone = $request->number_phone;
        if ($type == 'venue') {
            $vendor->address = $request->address;
            $vendor->total_guest = $request->total_guest;
        } else if ($type === 'catering') {
            $vendor->qty = $request->qty;
            $vendor->total_price = $request->price + $request->fee;
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

    public function updateVendor(Request $request, $id, $type)
    {
        $category = Category::where('name', $type)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'message' => 'Vendor not found'
            ], 404);
        }

        if ($category->id !== $vendor->category_id) {
            return response()->json([
                'message' => 'Vendor type does not match the category'
            ], 400);
        }

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'fee' => 'required|integer',
            'bank_number' => 'required|string',
            'number_phone' => 'required|string',
        ];

        if ($type === 'venue') {
            $rules['total_guest'] = 'required|integer';
            $rules['address'] = 'required|string';
        } else if ($type === 'catering') {
            $rules['qty'] = 'required|integer';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

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
        } else if ($type === 'catering') {
            $vendor->qty = $request->qty;
        }
        $vendor->save();
        return response()->json([
            'message' => 'Vendor updated successfully',
        ], 200);
    }

    public function deleteVendor($id, $type)
    {
        $category = Category::where('name', $type)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'message' => 'Vendor not found'
            ], 404);
        }

        if ($category->id !== $vendor->category_id) {
            return response()->json([
                'message' => 'Vendor type does not match the category'
            ], 400);
        }

        $vendor->delete();
        return response()->json([
            'message' => 'Vendor deleted successfully',
        ], 200);
    }

    public function detailVendor($id, $type)
    {
        $category = Category::where('name', $type)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'message' => 'Vendor not found'
            ], 404);
        }

        if ($category->id !== $vendor->category_id) {
            return response()->json([
                'message' => 'Vendor type does not match the category'
            ], 400);
        }

        return response()->json([
            'message' => 'Get detail vendor',
            'vendor' => $vendor->with('vendorAttachment')->first()
        ], 200);
    }

    public function getVendorByCategory($type)
    {
        $category = Category::where('name', $type)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $vendor = Vendor::where('category_id', $category->id)->with('vendorAttachment')->get();

        return response()->json([
            'message' => 'Get vendors by category',
            'data' => $vendor
        ], 200);
    }

    public function getVendors()
    {
        $vendor = Vendor::with('vendorAttachment')->get();

        return response()->json([
            'message' => 'Get vendors',
            'data' => $vendor
        ], 200);
    }
}
