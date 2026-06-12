@extends('layouts.app')

@section('title', 'Riwayat Order — Karsa Studio')

@section('content')
<<<<<<< HEAD
<div class="max-w-5xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Akun Saya</span>
            <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-white mt-4 leading-tight">
                Riwayat <span class="font-normal text-zinc-400">Order</span>
            </h1>
            <p class="text-zinc-400 text-sm leading-relaxed tracking-wide font-light max-w-2xl mt-4">
=======
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Akun Saya</span>
            <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">
                Riwayat <span class="font-normal text-zinc-400">Order</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mt-5">
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
                Semua order yang dibuat menggunakan akun {{ auth()->user()->email }} akan tampil di sini.
            </p>
        </div>

        <a href="{{ route('store') }}" class="inline-flex justify-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-6 rounded-lg tracking-widest transition-all duration-200 uppercase">
            Belanja Lagi
        </a>
    </div>

    @if($orders->isEmpty())
<<<<<<< HEAD
        <div class="border border-zinc-900 bg-zinc-950 p-10 rounded-2xl text-center">
            <h2 class="text-xl font-light text-white mb-3">Belum ada order</h2>
            <p class="text-zinc-500 text-xs leading-relaxed max-w-md mx-auto">
=======
        <div class="border border-zinc-900 bg-zinc-950 p-10 rounded-lg text-center">
            <h2 class="text-2xl font-semibold text-white mb-3">Belum ada order</h2>
            <p class="text-zinc-400 text-sm leading-relaxed max-w-md mx-auto">
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
                Setelah Anda melakukan checkout produk digital, riwayat order akan muncul di halaman ini.
            </p>
            <a href="{{ route('store') }}" class="mt-8 inline-flex justify-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-6 rounded-lg tracking-widest transition-all duration-200 uppercase">
                Buka Katalog
            </a>
        </div>
    @else
        <div class="space-y-5">
            @foreach($orders as $order)
<<<<<<< HEAD
                <article class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <h2 class="text-lg font-medium text-white tracking-wide">{{ $order->id }}</h2>
=======
                <article class="border border-zinc-900 bg-zinc-950 p-6 rounded-lg">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <h2 class="text-xl font-semibold text-white tracking-tight">{{ $order->id }}</h2>
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a

                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium bg-emerald-950/40 text-emerald-400 border border-emerald-900/50">SUKSES</span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium bg-amber-950/40 text-amber-400 border border-amber-900/50">PENDING</span>
                                @elseif($order->status === 'expired')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium bg-zinc-900 text-zinc-400 border border-zinc-800">KADALUARSA</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium bg-rose-950/40 text-rose-400 border border-rose-900/50">GAGAL</span>
                                @endif
                            </div>

                            <p class="text-zinc-500 text-xs">
                                Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB
                            </p>

                            <div class="mt-5 space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-t border-zinc-900 pt-3">
                                        <div>
                                            <h3 class="text-sm text-white font-medium">{{ $item->product->name }}</h3>
                                            <p class="text-[10px] text-zinc-500 mt-1">{{ $item->product->slug }}</p>
                                        </div>
                                        <span class="text-xs text-zinc-300 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="lg:text-right shrink-0">
                            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-2">Total</p>
                            <p class="text-2xl font-light text-white mb-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <a href="{{ route('order.status', ['order_id' => $order->id]) }}" class="inline-flex justify-center bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-semibold py-3 px-5 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                                Lihat Status
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
