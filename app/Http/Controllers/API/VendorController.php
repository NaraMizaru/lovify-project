<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function createVendor(Request $request)
    {
        $type = $request->query('type');

        if (!$type) {
            return response()->json(['message' => 'Type is required'], 422);
        }

        $mimeType = [
            'mua',
            'category',
            'description',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'fee'
        ]);

        if ($type === 'venue') {
        }

        
    }
}
