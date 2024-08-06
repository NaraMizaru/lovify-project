<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Str;
use Midtrans\Config;
use Midtrans\Snap;

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
        if ($request->payment_type === 'down payment') {
            $transaction->dp_price = $wedding->dp_price;
            $transaction->invoice = 'LOV-DP-' . Str::random(8);
        } else if ($request->payment_type === 'full payment') {
            $transaction->full_price = $wedding->price;
            $transaction->invoice = 'LOV-FULL-' . Str::random(8);
        }
        $transaction->price = $wedding->price;
        $transaction->date = now();
        $transaction->save();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice,
                'gross_amount' => $transaction->payment_type === 'down payment' ? $transaction->dp_price : $transaction->full_price,
            ],
            'customer_details' => [
                'name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->number_phone,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken, 
                'transaction' => $transaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
