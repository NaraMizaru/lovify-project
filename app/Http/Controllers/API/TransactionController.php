<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function createTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            
        ]);
    }
}
