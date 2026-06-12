<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
<<<<<<< HEAD
    public function dashboard(Request $request): View
=======
    public function dashboard(): View
    {
        Gate::authorize('viewAny', Product::class);

        $recentOrders = Order::with(['user', 'items.product'])->latest()->take(5)->get();
        $productCount = Product::count();
        $orderCount = Order::count();
        $paidOrderCount = Order::where('status', 'paid')->count();

        return view('admin.dashboard', compact('recentOrders', 'productCount', 'orderCount', 'paidOrderCount'));
    }

    public function index(): View
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    {
        Gate::authorize('viewAny', Product::class);

        $products = Product::latest()->get();
<<<<<<< HEAD
        $productCount = $products->count();
        $orderCount = Order::count();
        $paidOrderCount = Order::where('status', 'paid')->count();

        return view('admin.dashboard', compact('products', 'productCount', 'orderCount', 'paidOrderCount'));
    }

    public function create(Request $request): View
=======

        return view('admin.products.index', compact('products'));
    }

    public function orders(): View
    {
        Gate::authorize('access-admin');

        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function create(): View
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    {
        Gate::authorize('create', Product::class);

        return view('admin.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'required_without:image_path', 'image', 'max:2048'],
            'image_path' => ['nullable', 'required_without:image', 'string', 'max:255'],
            'download_url' => ['required', 'url', 'max:255'],
        ]);

<<<<<<< HEAD
        $slug = $data['slug'] ?? Str::slug($data['name']);
        $slug = $this->uniqueSlug($slug);

        $imagePath = $data['image_path'] ?? null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('images/products');

            if (! is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $fileName);
            $imagePath = 'images/products/' . $fileName;
=======
        $slug = ($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $slug = $this->uniqueSlug($slug);
        $imagePath = $data['image_path'] ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $this->storeImage($request, $slug);
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
        }

        Product::create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'],
            'price' => $data['price'],
            'image_path' => $imagePath,
            'download_url' => $data['download_url'],
        ]);

        return redirect()
<<<<<<< HEAD
            ->route('admin.dashboard')
            ->with('status_message', 'Produk katalog berhasil ditambahkan.');
    }

    private function uniqueSlug(string $slug): string
=======
            ->route('admin.products.index')
            ->with('status_message', 'Produk katalog berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        Gate::authorize('update', $product);

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        Gate::authorize('update', $product);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'download_url' => ['required', 'url', 'max:255'],
        ]);

        $slug = ($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $slug = $this->uniqueSlug($slug, $product);
        $imagePath = $request->filled('image_path') ? $data['image_path'] : $product->image_path;

        if ($request->hasFile('image')) {
            $imagePath = $this->storeImage($request, $slug);
        }

        $product->update([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'],
            'price' => $data['price'],
            'image_path' => $imagePath,
            'download_url' => $data['download_url'],
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('status_message', 'Produk katalog berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status_message', 'Produk katalog berhasil dihapus dari katalog user.');
    }

    private function uniqueSlug(string $slug, ?Product $ignoreProduct = null): string
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    {
        $baseSlug = Str::slug($slug);
        $candidate = $baseSlug;
        $counter = 2;

<<<<<<< HEAD
        while (Product::where('slug', $candidate)->exists()) {
=======
        while (Product::where('slug', $candidate)
            ->when($ignoreProduct, fn ($query) => $query->whereKeyNot($ignoreProduct->id))
            ->exists()) {
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
            $candidate = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $candidate;
    }
<<<<<<< HEAD
=======

    private function storeImage(Request $request, string $slug): string
    {
        $file = $request->file('image');
        $fileName = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('images/products');

        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        return 'images/products/' . $fileName;
    }
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
}
