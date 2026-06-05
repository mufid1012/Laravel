@extends('layouts.app')

@section('title', 'Karsa Studio — Minimalist Digital Assets Store')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">
    
    <!-- Hero Banner -->
    <div class="text-center md:text-left max-w-2xl mb-20 mt-8">
        <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-white mb-6 leading-tight">
            Elevating your digital workspace with <span class="font-normal text-zinc-400">minimalist aesthetics</span>.
        </h1>
        <p class="text-zinc-400 text-sm leading-relaxed tracking-wide font-light">
            A premium collection of high-fidelity desktop wallpapers, monochrome app icon bundles, Notion layouts, and structured log sheets built for focused minds.
        </p>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        @foreach($products as $product)
            <div class="group flex flex-col justify-between border border-zinc-900 bg-zinc-950 p-6 rounded-2xl hover:border-zinc-800 transition-all duration-300">
                <div>
                    <!-- Image Wrapper -->
                    <div class="relative w-full aspect-[16/10] overflow-hidden rounded-lg bg-zinc-900 border border-zinc-900/50 mb-6">
                        <img 
                            src="{{ asset($product->image_path) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover object-center group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Metadata -->
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <h2 class="text-lg font-medium text-white tracking-wide group-hover:text-zinc-200 transition-colors">
                            {{ $product->name }}
                        </h2>
                        <span class="text-sm font-semibold text-zinc-400 tracking-wide whitespace-nowrap">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-zinc-400 font-light text-xs leading-relaxed mb-8 tracking-wide">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Purchase Button Trigger -->
                <button 
                    onclick="openCheckoutModal('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}')" 
                    class="w-full text-center block bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase"
                >
                    Dapatkan Assets
                </button>
            </div>
        @endforeach
    </div>

    <!-- Features Section (Why Us) -->
    <div class="mt-32 border-t border-zinc-900 pt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Instant Delivery</h3>
            <p class="text-zinc-500 font-light text-xs leading-relaxed">
                Immediately receive direct, permanent download links once payment is authenticated by the gateway.
            </p>
        </div>
        <div>
            <h3 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Clean Aesthetic</h3>
            <p class="text-zinc-500 font-light text-xs leading-relaxed">
                Every wallpaper, icon, and template is meticulously curated to guarantee peak aesthetic layouts.
            </p>
        </div>
        <div>
            <h3 class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Secure Payments</h3>
            <p class="text-zinc-500 font-light text-xs leading-relaxed">
                Transactions are processed securely through a sandbox payment gateway using standard modern compliance.
            </p>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 z-50 hidden bg-zinc-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-md w-full p-8 shadow-2xl relative animate-in fade-in zoom-in-95 duration-200">
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
    function openCheckoutModal(id, name, price) {
        document.getElementById('modalProductId').value = id;
        document.getElementById('modalProductName').innerText = name;
        
        // Format price to Rupiah
        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(price);
        
        document.getElementById('modalProductPrice').innerText = formattedPrice;
        
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
    document.getElementById('checkoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCheckoutModal();
        }
    });
</script>
@endsection
