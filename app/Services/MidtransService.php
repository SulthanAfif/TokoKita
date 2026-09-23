<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $apiUrl;

    public function __construct()
    {
        $this->serverKey    = (string) config('midtrans.server_key', env('MIDTRANS_SERVER_KEY', ''));
        $this->clientKey    = (string) config('midtrans.client_key', env('MIDTRANS_CLIENT_KEY', ''));
        $this->isProduction = filter_var(
            config('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false)),
            FILTER_VALIDATE_BOOLEAN
        );
        $this->apiUrl = (string) config(
            'midtrans.api_url',
            $this->isProduction
                ? 'https://app.midtrans.com/snap/v1'
                : 'https://app.sandbox.midtrans.com/snap/v1'
        );
    }

    /**
     * Generate Snap Token.
     * order_id selalu unik (order_number + suffix) supaya bisa retry bayar.
     */
    public function createSnapToken(Order $order): ?array
    {
        if ($this->serverKey === '') {
            Log::error('Midtrans Server Key kosong. Set MIDTRANS_SERVER_KEY di Vercel env, lalu Redeploy.');
            return null;
        }

        $order->loadMissing(['items', 'user', 'address']);

        // WAJIB unik di Midtrans — jangan pakai order_number saja kalau sudah pernah dipakai
        $midtransOrderId = $order->order_number . '-' . Str::lower(Str::random(8));

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => (string) ($item->product_id ?? $item->id),
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr((string) $item->product_name, 0, 50),
            ];
        })->values()->toArray();

        if ((float) $order->shipping_cost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => (int) $order->total,
            ],
            'item_details'     => $itemDetails,
            'customer_details' => [
                'first_name' => $order->user->name ?? 'Customer',
                'email'      => $order->user->email ?? 'customer@example.com',
                'phone'      => $order->address?->phone
                    ?? $order->user->phone
                    ?? '08000000000',
            ],
            'callbacks' => [
                'finish' => route('orders.show', $order),
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->acceptJson()
                ->timeout(30)
                ->post(rtrim($this->apiUrl, '/') . '/transactions', $payload);

            if ($response->successful()) {
                $data  = $response->json();
                $token = $data['token'] ?? null;

                if ($token) {
                    $update = [];
                    if (Schema::hasColumn('orders', 'snap_token')) {
                        $update['snap_token'] = $token;
                    }
                    if (Schema::hasColumn('orders', 'midtrans_order_id')) {
                        $update['midtrans_order_id'] = $midtransOrderId;
                    }
                    if ($update) {
                        try {
                            $order->update($update);
                        } catch (\Throwable $e) {
                            Log::warning('Gagal simpan snap fields: ' . $e->getMessage());
                        }
                    }
                }

                return [
                    'token'        => $token,
                    'redirect_url' => $data['redirect_url'] ?? null,
                ];
            }

            Log::error('Midtrans Snap Token Error', [
                'order'    => $order->order_number,
                'midtrans_order_id' => $midtransOrderId,
                'status'   => $response->status(),
                'response' => $response->json() ?? $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage(), [
                'order' => $order->order_number,
            ]);
            return null;
        }
    }

    public function verifySignature(array $payload): bool
    {
        if ($this->serverKey === '') {
            return false;
        }

        $orderId     = $payload['order_id'] ?? '';
        $statusCode  = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signature   = $payload['signature_key'] ?? '';

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($expected, $signature);
    }

    public function mapTransactionStatus(string $transactionStatus, ?string $fraudStatus = null): string
    {
        if ($fraudStatus === 'challenge') {
            return 'pending';
        }

        return match ($transactionStatus) {
            'capture', 'settlement' => 'paid',
            'pending'               => 'pending',
            'deny', 'cancel', 'expire', 'failure' => 'cancelled',
            default                 => 'pending',
        };
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    public function getSnapJsUrl(): string
    {
        return (string) config(
            'midtrans.snap_js_url',
            $this->isProduction
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js'
        );
    }

    public function isConfigured(): bool
    {
        return $this->serverKey !== '' && $this->clientKey !== '';
    }
}
