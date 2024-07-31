<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request)
    {
        $credential = Validator::make($request->all(), [
            'name' => ['required','string'],
            'description' => ['required','string'],
            'price' => ['required','string'],
        ]);
    }
}
