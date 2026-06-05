<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentNotificationController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Handle payment notification from Midtrans.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        
        Log::info('Midtrans Webhook Received', $payload);

        // Verify signature
        if (!$this->midtrans->verifySignature($payload)) {
            Log::warning('Midtrans Webhook Invalid Signature', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Order ID missing'], 400);
        }

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Map Midtrans status to local database status
        $status = 'pending';
        
        if ($transactionStatus == 'capture') {
            if ($payload['fraud_status'] == 'accept') {
                $status = 'paid';
            } else {
                $status = 'failed';
            }
        } elseif ($transactionStatus == 'settlement') {
            $status = 'paid';
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $status = ($transactionStatus == 'expire') ? 'expired' : 'failed';
        } elseif ($transactionStatus == 'pending') {
            $status = 'pending';
        }

        // Update Order
        $order->update([
            'status' => $status,
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
        ]);

        Log::info("Order {$orderId} status updated to {$status}");

        return response()->json(['message' => 'Notification processed successfully']);
    }
}
