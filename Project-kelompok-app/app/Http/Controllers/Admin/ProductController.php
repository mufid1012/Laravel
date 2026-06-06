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
    public function dashboard(Request $request): View
    {
        Gate::authorize('viewAny', Product::class);

        $products = Product::latest()->get();
        $productCount = $products->count();
        $orderCount = Order::count();
        $paidOrderCount = Order::where('status', 'paid')->count();

        return view('admin.dashboard', compact('products', 'productCount', 'orderCount', 'paidOrderCount'));
    }

    public function create(Request $request): View
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
            ->route('admin.dashboard')
            ->with('status_message', 'Produk katalog berhasil ditambahkan.');
    }

    private function uniqueSlug(string $slug): string
    {
        $baseSlug = Str::slug($slug);
        $candidate = $baseSlug;
        $counter = 2;

        while (Product::where('slug', $candidate)->exists()) {
            $candidate = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $candidate;
    }
}
