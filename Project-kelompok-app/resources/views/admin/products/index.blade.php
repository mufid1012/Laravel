@extends('layouts.app')

@section('title', 'Kelola Katalog — Karsa Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div>
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Admin</span>
            <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">
                Kelola <span class="font-normal text-zinc-400">Katalog</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mt-5">
                Halaman khusus untuk melihat, mengedit, dan menghapus produk katalog Karsa Studio.
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

    <section class="border border-zinc-900 bg-zinc-950 rounded-lg overflow-hidden">
        @if($products->isEmpty())
            <div class="p-10 text-center">
                <h2 class="text-2xl font-semibold text-white mb-3">Belum ada produk katalog</h2>
                <p class="text-zinc-400 text-sm">Tambahkan katalog baru agar produk tampil di halaman user.</p>
            </div>
        @else
            <div class="divide-y divide-zinc-900">
                @foreach($products as $product)
                    <div class="p-6 flex flex-col md:flex-row md:items-center gap-5">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-full md:w-40 aspect-[16/10] object-cover rounded-lg border border-zinc-800 bg-zinc-900">

                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                            <p class="text-[10px] text-zinc-500 mt-1">{{ $product->slug }}</p>
                            <p class="text-sm text-zinc-400 leading-relaxed mt-3 line-clamp-2">{{ $product->description }}</p>
                        </div>

                        <div class="md:text-right shrink-0">
                            <p class="text-xs text-zinc-500 mb-1">Harga</p>
                            <p class="text-sm font-semibold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-4 flex flex-col sm:flex-row md:justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex justify-center bg-zinc-900 hover:bg-zinc-800 text-white text-[10px] font-semibold py-2.5 px-4 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari katalog user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center bg-rose-950/50 hover:bg-rose-900 text-rose-300 text-[10px] font-semibold py-2.5 px-4 rounded-lg border border-rose-900/60 tracking-widest transition-all duration-200 uppercase">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
