@extends('layouts.app')

@section('title', 'Dashboard — Karsa Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-14 md:py-20">
    <section class="min-h-[48vh] pb-14 flex flex-col items-center justify-center text-center">
        <div class="mb-7 flex flex-wrap items-center justify-center gap-3">
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">
                Karsa Studio
            </span>

            @auth
                <span class="inline-flex items-center gap-3 rounded-full border border-emerald-900/50 bg-emerald-950/20 px-4 py-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_18px_rgba(52,211,153,0.8)]"></span>
                    <span class="text-[10px] uppercase tracking-widest text-zinc-400">Masuk sebagai</span>
                    <strong class="text-xs font-semibold text-white">{{ auth()->user()->name }}</strong>
                </span>
            @else
                <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">
                    Guest Mode
                </span>
            @endauth
        </div>

        <h1 class="max-w-5xl text-5xl md:text-6xl font-extralight tracking-tight text-white leading-[1.05]">
            Digital assets for calm, intentional workspaces.
        </h1>

        <p class="mt-6 max-w-2xl text-sm md:text-base leading-relaxed text-zinc-400 font-light">
            Karsa Studio menyediakan wallpaper, icon pack, Notion dashboard, dan journal digital untuk membuat ruang kerja terasa lebih fokus, rapi, dan personal.
        </p>

        <div class="mt-9 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('store') }}" class="w-full sm:w-auto inline-flex justify-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-7 rounded-lg tracking-widest transition-all duration-200 uppercase">
                Buka Katalog
            </a>

            @guest
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex justify-center bg-zinc-950 hover:bg-zinc-900 text-white text-xs font-semibold py-3.5 px-7 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                    Login Akun
                </a>
            @else
                <a href="{{ route('orders.history') }}" class="w-full sm:w-auto inline-flex justify-center bg-zinc-950 hover:bg-zinc-900 text-white text-xs font-semibold py-3.5 px-7 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                    Riwayat Order
                </a>
            @endguest
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-3 border border-zinc-800 bg-zinc-950 rounded-lg overflow-hidden">
        <div class="p-8 md:p-10 md:border-r border-zinc-800">
            <div class="mb-8 flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-800 text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l5-5 4 4 3-3 4 4" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-white">Made for workspace</h2>
            <p class="text-zinc-400 text-base leading-relaxed mt-4">
                Wallpaper, icon pack, Notion dashboard, dan journal dibuat untuk ruang kerja yang rapi, tenang, dan mudah dipakai setiap hari.
            </p>
        </div>

        <div class="p-8 md:p-10 md:border-r border-zinc-800">
            <div class="mb-8 flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-800 text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10v10H7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-white">Preview before checkout</h2>
            <p class="text-zinc-400 text-base leading-relaxed mt-4">
                Setiap produk punya halaman detail berisi gambar, deskripsi, harga, dan format file sebelum user melanjutkan pembayaran.
            </p>
        </div>

        <div class="p-8 md:p-10">
            <div class="mb-8 flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-800 text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 12h8M8 17h5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3h14v18H5z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-white">Saved to your history</h2>
            <p class="text-zinc-400 text-base leading-relaxed mt-4">
                Order yang dibuat dari akun user tersimpan otomatis, sehingga status pembayaran dan akses download bisa dibuka kembali.
            </p>
        </div>
    </section>

    <section class="mt-16">
        <div class="mb-6 flex items-end justify-between gap-6">
            <div>
                <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Latest Catalog</span>
                <h2 class="mt-2 text-2xl font-light text-white">Produk terbaru</h2>
            </div>
            <a href="{{ route('store') }}" class="hidden sm:inline-flex text-xs font-semibold uppercase tracking-widest text-zinc-400 hover:text-white transition-colors">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse($featuredProducts as $product)
                <a href="{{ route('store') }}" class="group block overflow-hidden rounded-lg border border-zinc-900 bg-zinc-950 hover:border-zinc-700 transition-colors">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="aspect-[16/10] w-full object-cover opacity-85 group-hover:opacity-100 transition-opacity">
                    <div class="p-5">
                        <h3 class="truncate text-sm font-semibold text-white">{{ $product->name }}</h3>
                        <p class="mt-2 text-[10px] uppercase tracking-widest text-zinc-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @empty
                <div class="rounded-lg border border-zinc-900 bg-zinc-950 p-6">
                    <p class="text-xs text-zinc-500">Belum ada katalog. Admin dapat menambahkan produk melalui dashboard admin.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
