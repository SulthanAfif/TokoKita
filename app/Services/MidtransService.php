<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * MidtransService
 * ---------------
 * Service untuk berinteraksi dengan Midtrans Snap API.
 */
class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $apiUrl;

    public function __construct()
    {
        $this->serverKey    = (string) config('midtrans.server_key', '');
        $this->clientKey    = (string) config('midtrans.client_key', '');
        $this->isProduction = (bool) config('midtrans.is_production', false);
        $this->apiUrl       = (string) config('midtrans.api_url');
    }

    /**
     * Generate Snap Token untuk sebuah Order
     *
     * @return array{token: string, redirect_url: string|null}|null
     */
    public function createSnapToken(Order $order): ?array
    {
        if (empty($this->serverKey)) {
            Log::error('Midtrans Server Key kosong. Set MIDTRANS_SERVER_KEY di environment.');
            return null;
        }

        $order->loadMissing(['items', 'user', 'address']);

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => (string) ($item->product_id ?? $item->id),
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr((string) $item->product_name, 0, 50),
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

        // Null-safe: address / phone boleh kosong
        $customerDetails = [
            'first_name' => $order->user->name ?? 'Customer',
            'email'      => $order->user->email ?? 'customer@example.com',
            'phone'      => $order->address?->phone
                ?? $order->user->phone
                ?? '08000000000',
        ];

        $payload = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details'     => $itemDetails,
            'customer_details' => $customerDetails,
            'callbacks'        => [
                'finish' => route('orders.show', $order),
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->acceptJson()
                ->timeout(30)
                ->post(rtrim($this->apiUrl, '/') . '/transactions', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['token'] ?? null;

                if ($token && Schema::hasColumn('orders', 'snap_token')) {
                    try {
                        $order->update(['snap_token' => $token]);
                    } catch (\Throwable $e) {
                        Log::warning('Gagal simpan snap_token: ' . $e->getMessage());
                    }
                }

                return [
                    'token'        => $token,
                    'redirect_url' => $data['redirect_url'] ?? null,
                ];
            }

            Log::error('Midtrans Snap Token Error', [
                'order'    => $order->order_number,
                'status'   => $response->status(),
                'response' => $response->json() ?? $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage(), [
                'order' => $order->order_number,
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function verifySignature(array $payload): bool
    {
        if (empty($this->serverKey)) {
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
        return (string) config('midtrans.snap_js_url');
    }

    public function isConfigured(): bool
    {
        return $this->serverKey !== '' && $this->clientKey !== '';
    }
}
