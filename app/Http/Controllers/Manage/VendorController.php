<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request, $id)
    {
        $category = Category::find($id);

        $credential = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'fee' => ['required', 'integer'],
            'bank_number' => ['required', 'string'],
            'number_phone' => ['required', 'string'],
            'attachments.*' => ['required', 'file', 'mimes:png,jpg,jpeg']
        ];

        if ($category->name == 'venue') {
            $credential['total_guest'] = ['required', 'integer'];
            $credential['address'] = ['required', 'string'];
        } else if ($category->name == 'catering') {
            $credential['qty'] = ['required', 'integer'];
        }

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->description = $request->description;
        $vendor->price = $request->price;
        $vendor->fee = $request->fee;
        $vendor->bank_number = $request->bank_number;
        $vendor->number_phone = $request->number_phone;
        $vendor->category_id = $category->id;

        if ($category->name == 'catering') {
            $vendor->total_price = ($request->price + $request->fee) * $request->qty;
        } else {
            $vendor->total_price = $request->fee + $request->price;
        }

        if ($category->name == 'venue') {
            $vendor->total_guest = $request->total_guest;
            $vendor->address = $request->address;
        } else if ($category->name == 'catering') {
            $vendor->qty = $request->qty;
        }

        $images = $request->file('attachments');
        foreach ($images as $image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->store('vendor/' . $category->name . '/' . $vendor->name . '/' . $imageName, 'public');

            $vendorAttachment = new VendorAttachment();
            $vendorAttachment->image_path = $path;

            if (!$vendor->exists) {
                $vendor->save();
            }

            $vendorAttachment->vendor_id = $vendor->id;
            $vendorAttachment->save();
        }


        return redirect()->route('');
    }

    public function updateVendor(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        $category = Category::find($vendor->category_id);
        $credential = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'fee' => ['required', 'integer'],
            'bank_number' => ['required', 'string'],
            'number_phone' => ['required', 'string'],
        ];

        if ($category->name == 'venue') {
            $credential['total_guest'] = ['required', 'integer'];
            $credential['address'] = ['required', 'string'];
        } else if ($category->name == 'catering') {
            $credential['qty'] = ['required', 'integer'];
        }

        $validator = Validator::make($request->all(), $credential);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $vendor->name = $request->name;
        $vendor->description = $request->description;
        $vendor->price = $request->price;
        $vendor->fee = $request->fee;
        $vendor->bank_number = $request->bank_number;
        $vendor->number_phone = $request->number_phone;
        $vendor->total_price = $request->fee + $request->price;

        if ($category->name == 'venue') {
            $vendor->total_guest = $request->total_guest;
            $vendor->address = $request->address;
        } else if ($category->name == 'catering') {
            $vendor->qty = $request->qty;
        }

        $vendor->save();

        return redirect()->route('');
    }

    public function deleteVendor(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->back();
    }

    public function getAllVendors()
    {
        $vendors = Vendor::all();
        return view('', compact('vendors'));
    }

    public function getVendorsByCategory(Category $category)
    {
        $vendors = Vendor::where('category_id', $category->id)->get();
        return view('', compact('vendors'));
    }

    public function detailVendor(Vendor $vendor)
    {
        return view('', compact('vendor'));
    }
}
