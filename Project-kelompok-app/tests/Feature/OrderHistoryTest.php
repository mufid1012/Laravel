<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_order_history_to_login(): void
    {
        $this->get(route('orders.history'))->assertRedirect(route('login'));
    }

    public function test_checkout_attaches_order_to_authenticated_user(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Mesa Wallpaper Pack',
            'slug' => 'mesa-wallpaper-pack',
            'description' => 'Premium wallpaper pack.',
            'price' => 29000,
            'image_path' => 'images/mesa_wallpaper.png',
            'download_url' => 'https://example.com/downloads/mesa-wallpaper-pack.zip',
        ]);

        $this->actingAs($user)
            ->post(route('checkout'), [
                'product_id' => $product->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '08123456789',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'customer_email' => $user->email,
            'total_price' => 29000,
        ]);
    }

    public function test_user_only_sees_their_own_order_history(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::create([
            'name' => 'Focus Journal (PDF)',
            'slug' => 'focus-journal-pdf',
            'description' => 'Printable journal.',
            'price' => 19000,
            'image_path' => 'images/focus_journal.png',
            'download_url' => 'https://example.com/downloads/focus-journal.pdf',
        ]);

        $ownOrder = $this->createOrderForUser($user, $product, 'KS-OWN-1');
        $otherOrder = $this->createOrderForUser($otherUser, $product, 'KS-OTHER-1');

        $this->actingAs($user)
            ->get(route('orders.history'))
            ->assertOk()
            ->assertSee($ownOrder->id)
            ->assertDontSee($otherOrder->id);
    }

    public function test_user_cannot_view_another_users_order_status(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::create([
            'name' => 'Aura Notion Dashboard',
            'slug' => 'aura-notion-dashboard',
            'description' => 'Notion workspace.',
            'price' => 79000,
            'image_path' => 'images/aura_notion.png',
            'download_url' => 'https://example.com/downloads/aura-notion-dashboard.zip',
        ]);

        $otherOrder = $this->createOrderForUser($otherUser, $product, 'KS-OTHER-2');

        $this->actingAs($user)
            ->get(route('order.status', ['order_id' => $otherOrder->id]))
            ->assertForbidden();
    }

    private function createOrderForUser(User $user, Product $product, string $orderId): Order
    {
        $order = Order::create([
            'id' => $orderId,
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'total_price' => $product->price,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        return $order;
    }
}
