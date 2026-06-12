@extends('layouts.app')

@section('title', 'Admin Dashboard — Karsa Studio')

@section('content')
<<<<<<< HEAD
<div class="max-w-5xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Admin</span>
            <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-white mt-4 leading-tight">
                Dashboard <span class="font-normal text-zinc-400">Katalog</span>
            </h1>
            <p class="text-zinc-400 text-sm leading-relaxed tracking-wide font-light max-w-2xl mt-4">
                Kelola produk digital Karsa Studio. Produk yang ditambahkan di sini akan tampil di halaman katalog user.
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="inline-flex justify-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-6 rounded-lg tracking-widest transition-all duration-200 uppercase">
            Tambah Katalog
        </a>
=======
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Admin</span>
            <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">
                Dashboard <span class="font-normal text-zinc-400">Admin</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mt-5">
                Pusat kontrol admin Karsa Studio. Pilih menu khusus untuk kelola katalog, tambah produk, atau melihat order user.
            </p>
        </div>
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    </div>

    @if(session('status_message'))
        <div class="mb-8 p-4 bg-emerald-950/30 border border-emerald-900/50 text-emerald-300 text-xs rounded-lg tracking-wide">
            {{ session('status_message') }}
        </div>
    @endif

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<<<<<<< HEAD
        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
=======
        <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg">
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Total Produk</p>
            <h2 class="text-3xl font-light text-white">{{ $productCount }}</h2>
        </div>

<<<<<<< HEAD
        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
=======
        <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg">
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Total Order</p>
            <h2 class="text-3xl font-light text-white">{{ $orderCount }}</h2>
        </div>

<<<<<<< HEAD
        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
=======
        <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg">
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Order Sukses</p>
            <h2 class="text-3xl font-light text-white">{{ $paidOrderCount }}</h2>
        </div>
    </section>

<<<<<<< HEAD
    <section class="border border-zinc-900 bg-zinc-950 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-zinc-900 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium text-white">Daftar Katalog</h2>
                <p class="text-zinc-500 text-xs mt-1">Produk digital yang sedang tersedia di toko.</p>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="p-10 text-center">
                <p class="text-zinc-500 text-xs">Belum ada produk katalog.</p>
            </div>
        @else
            <div class="divide-y divide-zinc-900">
                @foreach($products as $product)
                    <div class="p-6 flex flex-col md:flex-row md:items-center gap-5">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-full md:w-36 aspect-[16/10] object-cover rounded-lg border border-zinc-800 bg-zinc-900">

                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-white">{{ $product->name }}</h3>
                            <p class="text-[10px] text-zinc-500 mt-1">{{ $product->slug }}</p>
                            <p class="text-xs text-zinc-400 leading-relaxed mt-3 line-clamp-2">{{ $product->description }}</p>
                        </div>

                        <div class="md:text-right shrink-0">
                            <p class="text-xs text-zinc-500 mb-1">Harga</p>
                            <p class="text-sm font-semibold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
=======
    <section class="grid grid-cols-1 md:grid-cols-3 border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden mb-12">
        <a href="{{ route('admin.products.index') }}" class="group p-8 md:border-r border-zinc-900 hover:bg-zinc-900/40 transition-colors">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-8">Katalog</p>
            <h2 class="text-2xl font-semibold text-white">Kelola katalog</h2>
            <p class="text-zinc-400 text-sm leading-relaxed mt-4">Lihat daftar produk, edit detail produk, atau hapus produk dari katalog user.</p>
            <span class="mt-8 inline-flex text-xs font-semibold uppercase tracking-widest text-zinc-400 group-hover:text-white">Buka katalog</span>
        </a>

        <a href="{{ route('admin.products.create') }}" class="group p-8 md:border-r border-zinc-900 hover:bg-zinc-900/40 transition-colors">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-8">Tambah</p>
            <h2 class="text-2xl font-semibold text-white">Tambah katalog</h2>
            <p class="text-zinc-400 text-sm leading-relaxed mt-4">Buat produk digital baru dengan gambar, deskripsi, harga, dan URL download.</p>
            <span class="mt-8 inline-flex text-xs font-semibold uppercase tracking-widest text-zinc-400 group-hover:text-white">Tambah produk</span>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="group p-8 hover:bg-zinc-900/40 transition-colors">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-8">Order</p>
            <h2 class="text-2xl font-semibold text-white">Order user</h2>
            <p class="text-zinc-400 text-sm leading-relaxed mt-4">Pantau order user, status pembayaran, total transaksi, dan produk yang dibeli.</p>
            <span class="mt-8 inline-flex text-xs font-semibold uppercase tracking-widest text-zinc-400 group-hover:text-white">Lihat order</span>
        </a>
    </section>

    <section class="border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden">
        <div class="p-6 border-b border-zinc-900">
            <h2 class="text-lg font-medium text-white">Order Terbaru</h2>
            <p class="text-zinc-500 text-xs mt-1">Ringkasan singkat order terbaru dari user.</p>
        </div>

        @forelse($recentOrders as $order)
            <div class="p-5 border-b border-zinc-900 last:border-b-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm font-semibold text-white">{{ $order->id }}</h3>
                    <p class="text-[10px] text-zinc-500 mt-1">{{ $order->user?->email ?? $order->customer_email }} · {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="sm:text-right">
                    <p class="text-xs text-zinc-300">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-zinc-500 mt-1">{{ $order->status }}</p>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <p class="text-zinc-500 text-xs">Belum ada order user.</p>
            </div>
        @endforelse
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
    </section>
</div>
@endsection
