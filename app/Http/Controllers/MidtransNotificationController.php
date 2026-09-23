<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request, MidtransService $midtrans)
    {
        try {
            $payload = $request->all();

            Log::info('Midtrans Notification Received', $payload);

            if (empty($payload)) {
                return response()->json(['message' => 'Empty payload'], 400);
            }

            if (!$midtrans->verifySignature($payload)) {
                Log::warning('Midtrans Invalid Signature', $payload);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $orderId           = $payload['order_id'] ?? null;
            $transactionStatus = $payload['transaction_status'] ?? null;
            $fraudStatus       = $payload['fraud_status'] ?? null;
            $transactionId     = $payload['transaction_id'] ?? null;
            $paymentType       = $payload['payment_type'] ?? null;

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::warning('Midtrans Order Not Found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            if (in_array($order->status, ['paid', 'processing', 'shipped', 'completed'])) {
                return response()->json(['message' => 'Order already processed']);
            }

            $newStatus = $midtrans->mapTransactionStatus(
                (string) $transactionStatus,
                $fraudStatus
            );

            DB::transaction(function () use ($order, $newStatus, $transactionId, $paymentType) {
                $updateData = [];

                if (Schema::hasColumn('orders', 'midtrans_transaction_id')) {
                    $updateData['midtrans_transaction_id'] = $transactionId;
                }
                if (Schema::hasColumn('orders', 'payment_type')) {
                    $updateData['payment_type'] = $paymentType;
                }

                if ($newStatus === 'paid') {
                    $updateData['status']  = 'paid';
                    $updateData['paid_at'] = now();
                } elseif ($newStatus === 'cancelled' && $order->status === 'pending') {
                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            Product::where('id', $item->product_id)
                                ->increment('stock', $item->quantity);
                        }
                    }
                    $updateData['status'] = 'cancelled';
                }

                if (!empty($updateData)) {
                    $order->update($updateData);
                }

                Log::info('Midtrans Order Updated', [
                    'order_number' => $order->order_number,
                    'new_status'   => $newStatus,
                ]);
            });

            return response()->json(['message' => 'OK']);
        } catch (\Throwable $e) {
            Log::error('Midtrans Notification Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            // Tetap return 200 agar Midtrans tidak spam retry berlebihan
            // (opsional: ganti 500 kalau mau Midtrans retry)
            return response()->json(['message' => 'Internal error'], 500);
        }
    }
}
