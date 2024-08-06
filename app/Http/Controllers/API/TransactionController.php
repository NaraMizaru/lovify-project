<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_type' => 'required|in:down payment,full payment',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $wedding = Wedding::find($id);

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->wedding_id = $wedding->id;
        $transaction->payment_type = $request->payment_type;
    }
}
