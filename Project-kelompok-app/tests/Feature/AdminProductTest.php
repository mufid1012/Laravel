<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Katalog');
    }

    public function test_role_gates_distinguish_admin_and_customer(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);

        $this->assertTrue(Gate::forUser($admin)->allows('access-admin'));
        $this->assertFalse(Gate::forUser($admin)->allows('access-customer'));

        $this->assertTrue(Gate::forUser($customer)->allows('access-customer'));
        $this->assertFalse(Gate::forUser($customer)->allows('access-admin'));
    }

<<<<<<< HEAD
    public function test_product_policy_only_allows_admin_to_create_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);

        $this->assertTrue($admin->can('create', Product::class));
        $this->assertFalse($customer->can('create', Product::class));
=======
    public function test_product_policy_only_allows_admin_to_manage_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);
        $product = Product::create([
            'name' => 'Policy Icons',
            'slug' => 'policy-icons',
            'description' => 'Product for policy assertions.',
            'price' => 25000,
            'image_path' => 'images/zen_icons.png',
            'download_url' => 'https://example.com/downloads/policy-icons.zip',
        ]);

        $this->assertTrue($admin->can('create', Product::class));
        $this->assertTrue($admin->can('update', $product));
        $this->assertTrue($admin->can('delete', $product));

        $this->assertFalse($customer->can('create', Product::class));
        $this->assertFalse($customer->can('update', $product));
        $this->assertFalse($customer->can('delete', $product));
    }

    public function test_admin_can_access_catalog_management_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Kelola')
            ->assertSee('Katalog');
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    }

    public function test_admin_is_redirected_from_user_pages_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->get(route('store'))
            ->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->get(route('orders.history'))
            ->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->post(route('checkout'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_add_catalog_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Minimal Workspace Icons',
                'description' => 'Icon pack premium untuk workspace modern.',
                'price' => 59000,
                'image_path' => 'images/zen_icons.png',
                'download_url' => 'https://example.com/downloads/minimal-workspace-icons.zip',
            ])
<<<<<<< HEAD
            ->assertRedirect(route('admin.dashboard'));
=======
            ->assertRedirect(route('admin.products.index'));
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a

        $this->assertDatabaseHas('products', [
            'name' => 'Minimal Workspace Icons',
            'slug' => 'minimal-workspace-icons',
            'price' => 59000,
        ]);

        $this->assertSame(1, Product::where('slug', 'minimal-workspace-icons')->count());
    }
<<<<<<< HEAD
=======

    public function test_admin_can_update_catalog_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::create([
            'name' => 'Old Icons',
            'slug' => 'old-icons',
            'description' => 'Old description.',
            'price' => 25000,
            'image_path' => 'images/zen_icons.png',
            'download_url' => 'https://example.com/downloads/old-icons.zip',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.products.update', $product), [
                'name' => 'Updated Icons',
                'slug' => 'updated-icons',
                'description' => 'Updated product description.',
                'price' => 65000,
                'image_path' => 'images/zen_icons.png',
                'download_url' => 'https://example.com/downloads/updated-icons.zip',
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Icons',
            'slug' => 'updated-icons',
            'price' => 65000,
        ]);
    }

    public function test_admin_can_soft_delete_catalog_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::create([
            'name' => 'Delete Me',
            'slug' => 'delete-me',
            'description' => 'Temporary product.',
            'price' => 15000,
            'image_path' => 'images/zen_icons.png',
            'download_url' => 'https://example.com/downloads/delete-me.zip',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }

    public function test_admin_can_view_user_orders_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Order User');
    }
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
}
