<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * MidtransService
 * ----------------
 * Wrapper tipis ke Midtrans Snap API menggunakan Http facade Laravel,
 * jadi tidak perlu install package composer midtrans/midtrans-php.
 *
 * Dokumentasi resmi: https://docs.midtrans.com/reference/snap-quick-start
 */
class MidtransService
{
    protected string $serverKey;
    protected bool $isProduction;

    public function __construct()
    {
        $this->serverKey    = (string) config('services.midtrans.server_key');
        $this->isProduction = (bool) config('services.midtrans.is_production');

        if (blank($this->serverKey)) {
            throw new RuntimeException('MIDTRANS_SERVER_KEY belum diisi di file .env');
        }
    }

    protected function snapUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    protected function statusUrl(string $orderId): string
    {
        $base = $this->isProduction
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';

        return "{$base}/v2/{$orderId}/status";
    }

    /**
     * Buat transaksi Snap untuk sebuah Order, dan kembalikan snap_token-nya.
     * order_id yang dikirim ke Midtrans WAJIB unik selamanya, jadi kita tempel
     * timestamp di belakang order_number supaya order yang dibayar ulang
     * (misalnya token lama sudah expired) tetap bisa membuat transaksi baru.
     */
    public function createSnapTransaction(Order $order): array
    {
        $midtransOrderId = $order->order_number . '-' . now()->timestamp;

        $payload = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => (int) round($order->total),
            ],
            'customer_details' => [
                'first_name' => $order->user->name ?? 'Customer',
                'email'      => $order->user->email ?? 'customer@example.com',
                'phone'      => $order->user->phone ?? null,
            ],
            'item_details' => $this->buildItemDetails($order),
            'callbacks' => [
                'finish' => route('orders.show', $order),
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->acceptJson()
            ->post($this->snapUrl(), $payload);

        if ($response->failed()) {
            Log::error('Midtrans: gagal membuat transaksi Snap', [
                'order_id' => $order->id,
                'response' => $response->json(),
            ]);
            throw new RuntimeException('Gagal membuat transaksi Midtrans: ' . ($response->json('error_messages.0') ?? $response->body()));
        }

        $snapToken = $response->json('token');

        $order->update([
            'snap_token'        => $snapToken,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        return [
            'token' => $snapToken,
            'redirect_url' => $response->json('redirect_url'),
        ];
    }

    protected function buildItemDetails(Order $order): array
    {
        $items = $order->items->map(function ($item) {
            return [
                'id'       => (string) ($item->product_id ?? $item->id),
                'name'     => \Illuminate\Support\Str::limit($item->product_name, 50, ''),
                'price'    => (int) round($item->price),
                'quantity' => (int) $item->quantity,
            ];
        })->toArray();

        if ((float) $order->shipping_cost > 0) {
            $items[] = [
                'id'       => 'ongkir',
                'name'     => 'Biaya Pengiriman',
                'price'    => (int) round($order->shipping_cost),
                'quantity' => 1,
            ];
        }

        return $items;
    }

    /**
     * Verifikasi signature_key dari payload notifikasi webhook Midtrans.
     * Rumus resmi: SHA512(order_id + status_code + gross_amount + ServerKey)
     */
    public function isValidSignature(array $payload): bool
    {
        $expected = hash('sha512',
            ($payload['order_id'] ?? '') .
            ($payload['status_code'] ?? '') .
            ($payload['gross_amount'] ?? '') .
            $this->serverKey
        );

        return hash_equals($expected, $payload['signature_key'] ?? '');
    }
}