@extends('layouts.app')

@section('title', 'Admin Dashboard — Karsa Studio')

@section('content')
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
    </div>

    @if(session('status_message'))
        <div class="mb-8 p-4 bg-emerald-950/30 border border-emerald-900/50 text-emerald-300 text-xs rounded-lg tracking-wide">
            {{ session('status_message') }}
        </div>
    @endif

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Total Produk</p>
            <h2 class="text-3xl font-light text-white">{{ $productCount }}</h2>
        </div>

        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Total Order</p>
            <h2 class="text-3xl font-light text-white">{{ $orderCount }}</h2>
        </div>

        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Order Sukses</p>
            <h2 class="text-3xl font-light text-white">{{ $paidOrderCount }}</h2>
        </div>
    </section>

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
    </section>
</div>
@endsection
