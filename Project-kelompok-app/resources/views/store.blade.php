@extends('layouts.app')

@section('title', 'Karsa Studio — Minimalist Digital Assets Store')

@section('content')
@php
    $productDetails = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'imageUrl' => asset($product->image_path),
            'format' => str_contains(strtolower($product->download_url), '.pdf') ? 'PDF digital siap unduh' : 'Arsip digital ZIP siap unduh',
            'benefits' => [
                'Dirancang dengan estetika minimalis khas Karsa Studio.',
                'File digital bisa digunakan setelah pembayaran berhasil.',
                'Cocok untuk mempercantik dan merapikan workspace pribadi.',
            ],
        ];
    })->values();
@endphp

<div class="max-w-6xl mx-auto px-6 py-16">
    
    <!-- Hero Banner -->
    <div class="text-center max-w-4xl mx-auto mb-16 mt-6">
        <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500 mb-7">
            Katalog Digital
        </span>
        <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mb-6 leading-[1.05]">
            Choose assets for a more intentional workspace.
        </h1>
        <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mx-auto">
            Buka detail produk terlebih dahulu untuk melihat deskripsi, harga, format file, dan manfaatnya sebelum lanjut checkout.
        </p>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($products as $product)
            <div class="group flex flex-col justify-between border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden hover:border-zinc-700 transition-all duration-300">
                <div>
                    <!-- Image Wrapper -->
                    <div class="relative w-full aspect-[16/10] overflow-hidden bg-zinc-900 border-b border-zinc-900">
                        <img 
                            src="{{ asset($product->image_path) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover object-center group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Metadata -->
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <h2 class="text-xl font-semibold text-white tracking-tight group-hover:text-zinc-200 transition-colors">
                                {{ $product->name }}
                            </h2>
                            <span class="text-xs font-semibold text-zinc-400 tracking-wide whitespace-nowrap">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="text-zinc-400 font-light text-sm leading-relaxed mb-7">
                            {{ \Illuminate\Support\Str::limit($product->description, 150) }}
                        </p>
                    </div>
                </div>

                <!-- Purchase Button Trigger -->
                <button
                    onclick="openProductDetail('{{ $product->id }}')"
                    class="m-6 mt-0 text-center block bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                >
                    Lihat Detail Produk
                </button>
            </div>
        @endforeach
    </div>

    <!-- Features Section (Why Us) -->
    <div class="mt-20 grid grid-cols-1 md:grid-cols-3 border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden">
        <div class="p-8 md:border-r border-zinc-900">
            <h3 class="text-xl font-semibold text-white mb-3">Detail first</h3>
            <p class="text-zinc-400 font-light text-sm leading-relaxed">
                Setiap katalog menampilkan informasi produk sebelum user masuk ke proses pembayaran.
            </p>
        </div>
        <div class="p-8 md:border-r border-zinc-900">
            <h3 class="text-xl font-semibold text-white mb-3">Clean aesthetic</h3>
            <p class="text-zinc-400 font-light text-sm leading-relaxed">
                Produk dibuat dengan visual minimal agar workspace terasa lebih rapi dan fokus.
            </p>
        </div>
        <div class="p-8">
            <h3 class="text-xl font-semibold text-white mb-3">Saved orders</h3>
            <p class="text-zinc-400 font-light text-sm leading-relaxed">
                Order dari akun user tersimpan di riwayat agar status dan akses produk mudah ditemukan.
            </p>
        </div>
    </div>
</div>

<!-- Product Detail Modal -->
<div id="productDetailModal" class="fixed inset-0 z-50 hidden bg-zinc-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-zinc-900 border border-zinc-800 rounded-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6 md:p-8 shadow-2xl relative animate-in fade-in zoom-in-95 duration-200">
        <button
            onclick="closeProductDetail()"
            class="absolute top-6 right-6 text-zinc-500 hover:text-white transition-colors"
            aria-label="Tutup detail produk"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-[0.95fr_1.05fr] gap-8">
            <div>
                <div class="relative w-full aspect-[16/10] overflow-hidden rounded-lg bg-zinc-950 border border-zinc-800">
                    <img id="detailProductImage" src="" alt="" class="w-full h-full object-cover object-center">
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="bg-zinc-950 border border-zinc-800 rounded-lg p-4">
                        <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold">Harga</p>
                        <p id="detailProductPrice" class="text-sm font-semibold text-white mt-1"></p>
                    </div>
                    <div class="bg-zinc-950 border border-zinc-800 rounded-lg p-4">
                        <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold">Format</p>
                        <p id="detailProductFormat" class="text-xs text-zinc-300 mt-1 leading-relaxed"></p>
                    </div>
                </div>
            </div>

            <div class="pr-6 md:pr-8">
                <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Detail Produk</span>
                <h3 id="detailProductName" class="text-2xl font-light text-white tracking-wide mt-2 mb-4"></h3>
                <p id="detailProductDescription" class="text-zinc-400 text-xs leading-relaxed font-light"></p>

                <div class="mt-7 border-t border-zinc-800 pt-6">
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-4">Yang Anda Dapatkan</h4>
                    <ul id="detailProductBenefits" class="space-y-3"></ul>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    @auth
                        <button
                            type="button"
                            onclick="continueToCheckout()"
                            class="flex-1 bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                        >
                            Lanjut Checkout
                        </button>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="flex-1 text-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                        >
                            Login untuk Checkout
                        </a>
                    @endauth

                    <button
                        type="button"
                        onclick="closeProductDetail()"
                        class="flex-1 bg-zinc-950 hover:bg-zinc-800 text-white text-xs font-semibold py-3.5 px-5 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase"
                    >
                        Kembali ke Katalog
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 z-50 hidden bg-zinc-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-zinc-900 border border-zinc-800 rounded-lg max-w-md w-full p-8 shadow-2xl relative animate-in fade-in zoom-in-95 duration-200">
        <!-- Close Button -->
        <button 
            onclick="closeCheckoutModal()" 
            class="absolute top-6 right-6 text-zinc-500 hover:text-white transition-colors"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Product Summary -->
        <div class="mb-6">
            <span class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold">Anda Membeli</span>
            <h3 id="modalProductName" class="text-lg font-medium text-white tracking-wide mt-1"></h3>
            <p id="modalProductPrice" class="text-sm font-semibold text-zinc-400 mt-1"></p>
        </div>

        <hr class="border-zinc-800 my-6">

        <!-- Form -->
        <form action="{{ route('checkout') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="product_id" id="modalProductId">

            <div>
                <label for="customer_name" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="customer_name" 
                    id="customer_name" 
                    value="{{ auth()->user()->name ?? old('customer_name') }}"
                    required 
                    placeholder="Contoh: John Doe" 
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div>
                <label for="customer_email" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Email Address</label>
                <input 
                    type="email" 
                    name="customer_email" 
                    id="customer_email" 
                    value="{{ auth()->user()->email ?? old('customer_email') }}"
                    required 
                    placeholder="Contoh: john@example.com" 
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div>
                <label for="customer_phone" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Nomor Telepon (Optional)</label>
                <input 
                    type="text" 
                    name="customer_phone" 
                    id="customer_phone" 
                    placeholder="Contoh: 08123456789" 
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                >
                    Lanjutkan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const products = @json($productDetails);
    let selectedProduct = null;

    function rupiah(price) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(price);
    }

    function openProductDetail(id) {
        selectedProduct = products.find((product) => String(product.id) === String(id));

        if (!selectedProduct) {
            return;
        }

        document.getElementById('detailProductImage').src = selectedProduct.imageUrl;
        document.getElementById('detailProductImage').alt = selectedProduct.name;
        document.getElementById('detailProductName').innerText = selectedProduct.name;
        document.getElementById('detailProductDescription').innerText = selectedProduct.description;
        document.getElementById('detailProductPrice').innerText = rupiah(selectedProduct.price);
        document.getElementById('detailProductFormat').innerText = selectedProduct.format;

        const benefits = document.getElementById('detailProductBenefits');
        benefits.innerHTML = '';

        selectedProduct.benefits.forEach((benefit) => {
            const item = document.createElement('li');
            item.className = 'flex items-start gap-3 text-xs text-zinc-400 leading-relaxed';
            item.innerHTML = '<span class="mt-1 h-1.5 w-1.5 rounded-full bg-zinc-500 shrink-0"></span><span></span>';
            item.querySelector('span:last-child').innerText = benefit;
            benefits.appendChild(item);
        });

        const modal = document.getElementById('productDetailModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeProductDetail() {
        const modal = document.getElementById('productDetailModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function continueToCheckout() {
        if (!selectedProduct) {
            return;
        }

        closeProductDetail();
        openCheckoutModal(selectedProduct.id, selectedProduct.name, selectedProduct.price);
    }

    function openCheckoutModal(id, name, price) {
        document.getElementById('modalProductId').value = id;
        document.getElementById('modalProductName').innerText = name;
        document.getElementById('modalProductPrice').innerText = rupiah(price);
        
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on click outside modal content
    document.getElementById('productDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductDetail();
        }
    });

    document.getElementById('checkoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCheckoutModal();
        }
    });
</script>
@endsection
