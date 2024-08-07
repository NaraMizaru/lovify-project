<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Str;
use Midtrans\Config;
use Midtrans\Notification;
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

        if ($wedding->user_id !== $user->id) {
            return response()->json([
                'message' => 'Forbidden Access',
            ], 403);
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->wedding_id = $wedding->id;
        $transaction->payment_type = $request->payment_type;
        if ($request->payment_type === 'down payment') {
            $transaction->dp_price = $wedding->dp_price;
            $transaction->invoice = 'LOV-DP-' . Str::random(16);
        } else if ($request->payment_type === 'full payment') {
            $transaction->full_price = $wedding->price;
            $transaction->invoice = 'LOV-FULL-' . Str::random(16);
        }
        $transaction->price = $wedding->price;
        $transaction->transaction_date = now();
        $transaction->save();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice,
                'gross_amount' => $transaction->payment_type === 'down payment' ? $transaction->dp_price : $transaction->full_price,
            ],
            'customer_details' => [
                'first_name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->number_phone,
            ],
            'product details' => [
                'product_id' => $wedding->id,
                'product_name' => $wedding->name,
                'price' => $wedding->price,
                'subtotal' => $wedding->price
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'transaction' => $transaction->with(['user', 'wedding'])->first()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function payRemaining(Request $request, $id, $transactionId)
    {
        $transaction = Transaction::where('invoice', $transactionId)->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        if ($transaction->status !== 'success' || $transaction->payment_type !== 'down payment' || $transaction->payment_type !== 'down payment' && $transaction->full_price !== NULL) {
            return response()->json(['error' => 'Transaction is not eligible for remaining payment'], 400);
        }

        $user = $request->user();

        if ($transaction->user_id !== $user->id) {
            return response()->json([
                'message' => 'Forbidden Access',
            ], 403);
        }

        $wedding = Wedding::find($id);

        $invoice = 'LOV-FULL-' . Str::random(16);

        $params = [
            'transaction_details' => [
                'order_id' => $invoice,
                'gross_amount' => $transaction->price - $transaction->dp_price,
            ],
            'customer_details' => [
                'first_name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->number_phone,
            ],
            'product details' => [
                'product_id' => $wedding->id,
                'product_name' => $wedding->name,
                'price' => $wedding->price,
                'subtotal' => $wedding->price
            ]
        ];

        $transaction->status = 'process';
        $transaction->condition = NULL;
        $transaction->full_price = $transaction->price - $transaction->dp_price;
        $transaction->invoice = $invoice;
        $transaction->save();

        try {
            $snapToken = Snap::getSnapToken($params);
            
            return response()->json([
                'snap_token' => $snapToken,
                'invoice' => $invoice
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $transactionId = $notification->order_id;

            $transaction = Transaction::where('invoice', $transactionId)->first();

            if (!$transaction) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($notification->payment_type == 'credit_card') {
                    if ($notification->fraud_status == 'challenge') {
                        $transaction->condition = 'fraud';
                    } else {
                        $transaction->condition = 'accept';
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $transaction->status = 'success';
                $transaction->condition = 'accept';
            } elseif ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            } elseif ($transactionStatus == 'deny') {
                $transaction->status = 'failed';
                $transaction->condition = 'reject';
            } elseif ($transactionStatus == 'expire') {
                $transaction->status = 'failed';
                $transaction->condition = 'reject';
            } elseif ($transactionStatus == 'cancel') {
                $transaction->status = 'failed';
                $transaction->condition = 'reject';
            }

            $transaction->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
