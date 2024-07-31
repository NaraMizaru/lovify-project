<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request, $id)
    {
        $category = Category::find($id);

        if ($category->name == 'venue') {
            $credential = Validator::make($request->all(), [
                'name' => ['required','string'],
                'description' => ['required','string'],
                'price' => ['required','integer'],
                'address' => ['required','string'],
                'total_guest' => ['required','integer'],
            ]);
        } else {
            $credential = Validator::make($request->all(), [
                'name' => ['required','string'],
                'description' => ['required','string'],
                'price' => ['required','integer'],
            ]);
        }

        if ($credential->fails()) {
            return redirect()->back()->withErrors($credential->errors())->withInput($request->all());
        }

        if ($category->name == 'venue') {
            $vendor =  new Vendor();
            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->price = $request->price;
            $vendor->address = $request->address;
            $vendor->total_guest = $request->total_guest;
            $vendor->category_id = $category->id;
            $vendor->save();
        } else {
            $vendor =  new Vendor();
            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->price = $request->price;
            $vendor->category_id = $category->id;
            $vendor->save();
        }

        return redirect()->route('');
    }

    public function updateVendor(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        $category = Category::find($vendor->category_id);

        if ($category->name == 'venue') {
            $credential = Validator::make($request->all(), [
                'name' => ['required','string'],
                'description' => ['required','string'],
                'price' => ['required','integer'],
                'address' => ['required','string'],
                'total_guest' => ['required','integer'],
            ]);
        } else {
            $credential = Validator::make($request->all(), [
                'name' => ['required','string'],
                'description' => ['required','string'],
                'price' => ['required','integer'],
            ]);
        }

        if ($credential->fails()) {
            return redirect()->back()->withErrors($credential->errors())->withInput($request->all());
        }
        if ($category->name == 'venue') {
            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->price = $request->price;
            $vendor->address = $request->address;
            $vendor->total_guest = $request->total_guest;
            $vendor->category_id = $category->id;
            $vendor->save();
        } else {
            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->price = $request->price;
            $vendor->category_id = $category->id;
            $vendor->save();
        }

        return redirect()->route('');
    }

    public function deleteVendor($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        return redirect()->route('');
    }
}
