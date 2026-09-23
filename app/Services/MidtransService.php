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
        $this->serverKey = trim((string) config('midtrans.server_key', ''));
        $this->clientKey = trim((string) config('midtrans.client_key', ''));
        $this->isProduction = (bool) config('midtrans.is_production', false);
        $this->apiUrl = (string) (
            config('midtrans.api_url')
            ?: ($this->isProduction
                ? 'https://app.midtrans.com/snap/v1'
                : 'https://app.sandbox.midtrans.com/snap/v1')
        );
    }

    public function createSnapToken(Order $order): ?array
    {
        if ($this->serverKey === '') {
            Log::error('Midtrans Server Key kosong');
            return null;
        }

        $order->loadMissing(['items', 'user', 'address']);

        $midtransOrderId = $order->order_number . '-' . Str::lower(Str::random(8));

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => (string) ($item->product_id ?? $item->id),
                'price'    => (int) round((float) $item->price),
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr((string) ($item->product_name ?: 'Produk'), 0, 50),
            ];
        })->values()->toArray();

        $shipping = (int) round((float) $order->shipping_cost);
        if ($shipping > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => $shipping,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];
        }

        // Midtrans wajib: sum(item) == gross_amount
        $grossAmount = 0;
        foreach ($itemDetails as $row) {
            $grossAmount += $row['price'] * $row['quantity'];
        }

        $payload = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => $grossAmount,
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
                'finish' => url('/pesanan/' . $order->id),
            ],
        ];

        Log::info('Midtrans createSnap request', [
            'api_url' => $this->apiUrl,
            'is_production' => $this->isProduction,
            'order_id' => $midtransOrderId,
            'gross_amount' => $grossAmount,
            'server_key_prefix' => substr($this->serverKey, 0, 12),
        ]);

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
                'status'   => $response->status(),
                'response' => $response->json() ?? $response->body(),
                'api_url'  => $this->apiUrl,
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
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
        return (string) (
            config('midtrans.snap_js_url')
            ?: ($this->isProduction
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js')
        );
    }

    public function isConfigured(): bool
    {
        return $this->serverKey !== '' && $this->clientKey !== '';
    }
}
