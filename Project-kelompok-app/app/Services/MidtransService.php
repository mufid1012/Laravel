<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $snapUrl;

    public function __construct()
    {
        $this->serverKey = env('MIDTRANS_SERVER_KEY');
        $this->clientKey = env('MIDTRANS_CLIENT_KEY');
        $this->isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

        $this->snapUrl = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * Determine if Midtrans is fully configured and ready for live/sandbox API calls.
     */
    public function isConfigured(): bool
    {
        return !empty($this->serverKey) && !str_starts_with($this->serverKey, 'YOUR_');
    }

    /**
     * Generate Midtrans Snap token for checkout.
     */
    public function getSnapToken($order): ?string
    {
        if (!$this->isConfigured()) {
            Log::info("Midtrans not configured. Generating simulation token for order ID: {$order->id}");
            return 'simulated-token-' . uniqid();
        }

        // Build item details
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->product->id,
                'price' => (int) $item->price,
                'quantity' => 1,
                'name' => substr($item->product->name, 0, 50),
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => (int) $order->total_price,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('order.status', ['order_id' => $order->id]),
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->withBasicAuth($this->serverKey, '')
            ->post($this->snapUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return $data['token'] ?? null;
            }

            Log::error('Midtrans API Request Failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
        }

        // Fall back to simulation token on API failure
        return 'simulated-token-fallback-' . uniqid();
    }

    /**
     * Verify Midtrans Signature Key to authenticate webhooks.
     */
    public function verifySignature(array $payload): bool
    {
        if (!$this->isConfigured()) {
            return true; // Trust callbacks in Simulation Mode
        }

        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        
        $signature = hash("sha512", $orderId . $statusCode . $grossAmount . $this->serverKey);
        
        return hash_equals($signature, $payload['signature_key'] ?? '');
    }
}
