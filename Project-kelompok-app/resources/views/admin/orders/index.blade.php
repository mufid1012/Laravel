@extends('layouts.app')

@section('title', 'Order User — Karsa Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Admin</span>
            <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">
                Order <span class="font-normal text-zinc-400">User</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mt-5">
                Lihat semua order yang dibuat user, produk yang dibeli, total pembayaran, dan status transaksi.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-semibold py-3.5 px-6 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
            Dashboard Admin
        </a>
    </div>

    <section class="border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden">
        @forelse($orders as $order)
            <article class="p-6 border-b border-zinc-900 last:border-b-0">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-xl font-semibold text-white tracking-tight">{{ $order->id }}</h2>

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

                        <p class="text-zinc-500 text-xs mt-2">
                            {{ $order->created_at->format('d M Y, H:i') }} WIB · {{ $order->user?->name ?? $order->customer_name }} · {{ $order->user?->email ?? $order->customer_email }}
                        </p>

                        <div class="mt-5 space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-t border-zinc-900 pt-3">
                                    <div>
                                        <h3 class="text-sm text-white font-medium">{{ $item->product->name }}</h3>
                                        <p class="text-[10px] text-zinc-500 mt-1">{{ $item->product->trashed() ? 'Produk sudah dihapus dari katalog' : $item->product->slug }}</p>
                                    </div>
                                    <span class="text-xs text-zinc-300 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:text-right shrink-0">
                        <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-2">Total</p>
                        <p class="text-2xl font-light text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-zinc-500 mt-4">Payment</p>
                        <p class="text-xs text-zinc-300 mt-1">{{ $order->payment_type ?? 'Belum ada' }}</p>
                    </div>
                </div>
            </article>
        @empty
            <div class="p-10 text-center">
                <h2 class="text-2xl font-semibold text-white mb-3">Belum ada order user</h2>
                <p class="text-zinc-400 text-sm">Order akan muncul setelah user melakukan checkout.</p>
            </div>
        @endforelse
    </section>
</div>
@endsection
