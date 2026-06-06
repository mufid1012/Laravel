@extends('layouts.app')

@section('title', 'Karsa Studio — Status Pembayaran')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16">
    
    <!-- Status Card Header -->
    <div class="text-center mb-12 max-w-3xl mx-auto">
        <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Transaksi Detail</span>
        <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">Order {{ $order->id }}</h1>
        <p class="text-zinc-500 text-xs mt-4">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="max-w-2xl mx-auto">
    <!-- Status Banner / Timeline -->
    <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg mb-8">
        
        <!-- Status Info -->
        <div class="flex items-center justify-between mb-8">
            <span class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Status Pembayaran</span>
            
            @if($order->status == 'paid')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-950/40 text-emerald-400 border border-emerald-900/50">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    SUKSES
                </span>
            @elseif($order->status == 'pending')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-950/40 text-amber-400 border border-amber-900/50">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    PENDING
                </span>
            @elseif($order->status == 'expired')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-zinc-900 text-zinc-400 border border-zinc-800">
                    KADALUARSA
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-rose-950/40 text-rose-400 border border-rose-900/50">
                    GAGAL
                </span>
            @endif
        </div>

        @if(session('status_message'))
            <div class="mb-6 p-4 bg-zinc-900 border border-zinc-800 text-zinc-300 text-xs rounded-lg tracking-wide">
                {{ session('status_message') }}
            </div>
        @endif

        <!-- Main Display Content depending on Status -->
        @if($order->status == 'paid')
            <div class="space-y-6">
                <div class="bg-zinc-900/40 border border-zinc-900 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold tracking-tight text-white mb-2">Terima kasih atas pembelian Anda</h3>
                    <p class="text-zinc-400 text-sm font-light leading-relaxed mb-6">
                        Pembayaran Anda telah diverifikasi oleh gateway. Anda sekarang dapat mengunduh produk digital premium Anda menggunakan tombol di bawah ini.
                    </p>

                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between border-t border-zinc-800/80 pt-4 mt-4">
                            <div>
                                <h4 class="text-xs font-medium text-white">{{ $item->product->name }}</h4>
                                <p class="text-[10px] text-zinc-500 mt-0.5">Format File: Direct Archive (.zip / .pdf)</p>
                            </div>
                            <a 
                                href="{{ $item->product->download_url }}" 
                                target="_blank"
                                class="bg-white hover:bg-zinc-200 text-zinc-950 text-[10px] font-bold py-2.5 px-5 rounded-md tracking-wider uppercase transition-colors"
                            >
                                Unduh File
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif($order->status == 'pending')
            <div class="space-y-6">
                <p class="text-zinc-400 text-sm leading-relaxed font-light">
                    Selesaikan pembayaran sebesar <strong class="text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> untuk mendapatkan akses produk.
                </p>

                <!-- Payment trigger button -->
                @if($midtransConfigured && !str_starts_with($order->snap_token, 'simulated-token-'))
                    <button 
                        id="payButton"
                        class="w-full bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                    >
                        Bayar Sekarang (Midtrans)
                    </button>
                @else
                    <div class="p-6 bg-zinc-900 border border-zinc-850 rounded-lg space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <div>
                                <h4 class="text-xs font-semibold text-white">Mode Simulasi Aktif</h4>
                                <p class="text-[11px] text-zinc-400 font-light mt-1 leading-relaxed">
                                    Midtrans API credentials belum dikonfigurasi di file <code>.env</code>. Anda dapat mensimulasikan status pembayaran di bawah ini.
                                </p>
                            </div>
                        </div>

                        <!-- Simulation form actions -->
                        <div class="grid grid-cols-3 gap-3 pt-2">
                            <form action="{{ route('order.simulate-pay', ['order_id' => $order->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="paid">
                                <button type="submit" class="w-full bg-emerald-950/60 hover:bg-emerald-900 border border-emerald-900 text-emerald-400 text-[10px] font-medium py-2 px-3 rounded-md transition-colors uppercase tracking-wider">
                                    Simulasi Sukses
                                </button>
                            </form>
                            
                            <form action="{{ route('order.simulate-pay', ['order_id' => $order->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="expired">
                                <button type="submit" class="w-full bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-400 text-[10px] font-medium py-2 px-3 rounded-md transition-colors uppercase tracking-wider">
                                    Simulasi Expire
                                </button>
                            </form>

                            <form action="{{ route('order.simulate-pay', ['order_id' => $order->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="failed">
                                <button type="submit" class="w-full bg-rose-950/60 hover:bg-rose-900 border border-rose-900 text-rose-400 text-[10px] font-medium py-2 px-3 rounded-md transition-colors uppercase tracking-wider">
                                    Simulasi Gagal
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        @else
            <div>
                <p class="text-zinc-400 text-xs leading-relaxed font-light mb-6">
                    Transaksi ini gagal atau telah kadaluarsa. Silakan lakukan pemesanan ulang melalui halaman utama.
                </p>
                <a 
                    href="{{ route('store') }}" 
                    class="w-full text-center block bg-zinc-900 hover:bg-zinc-850 text-white text-xs font-semibold py-3.5 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase"
                >
                    Kembali ke Katalog
                </a>
            </div>
        @endif
    </div>

    <!-- Order Item Summary Cards -->
    <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg">
        <h3 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-6">Ringkasan Order</h3>
        
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between text-xs py-1">
                    <span class="text-zinc-400 font-light">{{ $item->product->name }}</span>
                    <span class="text-white font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
            @endforeach

            <hr class="border-zinc-900 my-4">

            <div class="flex items-center justify-between text-xs py-1">
                <span class="text-zinc-500 font-light">Subtotal</span>
                <span class="text-zinc-400 font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

            <div class="flex items-center justify-between text-xs py-1">
                <span class="text-zinc-500 font-light">Biaya Transaksi</span>
                <span class="text-zinc-400 font-medium">Rp 0</span>
            </div>

            <div class="flex items-center justify-between text-sm py-2 border-t border-zinc-900 mt-2">
                <span class="text-white font-semibold">Total Pembayaran</span>
                <span class="text-white font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <hr class="border-zinc-900 my-6">

        <!-- Customer details -->
        <h3 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-4">Informasi Pelanggan</h3>
        <div class="space-y-2 text-xs">
            <div class="flex items-center justify-between">
                <span class="text-zinc-500 font-light">Nama</span>
                <span class="text-zinc-300">{{ $order->customer_name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-zinc-500 font-light">Email</span>
                <span class="text-zinc-300">{{ $order->customer_email }}</span>
            </div>
            @if($order->customer_phone)
                <div class="flex items-center justify-between">
                    <span class="text-zinc-500 font-light">Telepon</span>
                    <span class="text-zinc-300">{{ $order->customer_phone }}</span>
                </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
@if($order->status == 'pending' && $midtransConfigured && !str_starts_with($order->snap_token, 'simulated-token-'))
    <!-- Midtrans Snap JS Integration -->
    <script src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
    <script>
        const payButton = document.getElementById('payButton');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result) {
                    console.log('payment success', result);
                    window.location.reload();
                },
                onPending: function(result) {
                    console.log('payment pending', result);
                    window.location.reload();
                },
                onError: function(result) {
                    console.log('payment error', result);
                    window.location.reload();
                },
                onClose: function() {
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    </script>
@endif
@endsection
