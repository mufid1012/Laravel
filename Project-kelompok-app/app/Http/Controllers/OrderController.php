<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Display storefront with list of products.
     */
    public function index(Request $request)
    {
        if ($request->user() && Gate::forUser($request->user())->denies('access-customer')) {
            return redirect()->route('admin.dashboard');
        }

        $products = Product::all();
        $midtransConfigured = $this->midtrans->isConfigured();
        
        return view('store', compact('products', 'midtransConfigured'));
    }

    /**
     * Display authenticated user's order history.
     */
    public function history(Request $request)
    {
        if (Gate::denies('access-customer')) {
            return redirect()->route('admin.dashboard');
        }

        Gate::authorize('viewAny', Order::class);

        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('orders.history', compact('orders'));
    }

    /**
     * Process checkout request and generate transaction token.
     */
    public function checkout(Request $request)
    {
        if (Gate::denies('access-customer')) {
            return redirect()->route('admin.dashboard');
        }

        Gate::authorize('create', Order::class);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Generate unique order ID prefix KS (Karsa Studio)
        $orderId = 'KS-' . strtoupper(Str::random(3)) . '-' . time();

        // Create Order
        $order = Order::create([
            'id' => $orderId,
            'user_id' => $request->user()->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $product->price,
            'status' => 'pending',
        ]);

        // Create Order Item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        // Generate Snap Token
        $snapToken = $this->midtrans->getSnapToken($order);
        
        $order->update([
            'snap_token' => $snapToken
        ]);

        return redirect()->route('order.status', ['order_id' => $order->id]);
    }

    /**
     * Display order status and download link if paid.
     */
    public function status($order_id, Request $request)
    {
        if ($request->user() && Gate::forUser($request->user())->denies('access-customer')) {
            return redirect()->route('admin.dashboard');
        }

        $order = Order::with('items.product')->findOrFail($order_id);
        Gate::authorize('view', $order);

        $midtransConfigured = $this->midtrans->isConfigured();
        $clientKey = env('MIDTRANS_CLIENT_KEY', '');
        $isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

        return view('status', compact('order', 'midtransConfigured', 'clientKey', 'isProduction'));
    }

    /**
     * Simulate payment for local testing without Midtrans keys.
     */
    public function simulatePay($order_id, Request $request)
    {
        if ($request->user() && Gate::forUser($request->user())->denies('access-customer')) {
            return redirect()->route('admin.dashboard');
        }

        $order = Order::findOrFail($order_id);
        Gate::authorize('simulatePayment', $order);
        
        // Acceptable statuses: paid, expired, failed
        $targetStatus = $request->input('status', 'paid');
        if (!in_array($targetStatus, ['paid', 'expired', 'failed'])) {
            $targetStatus = 'paid';
        }

        $order->update([
            'status' => $targetStatus,
            'payment_type' => 'simulation',
            'transaction_id' => 'SIM-' . strtoupper(Str::random(10)),
        ]);

        return redirect()->route('order.status', ['order_id' => $order->id])
            ->with('status_message', 'Payment status updated to: ' . strtoupper($targetStatus));
    }

}
