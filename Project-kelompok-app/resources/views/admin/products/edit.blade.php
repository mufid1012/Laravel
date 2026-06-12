@extends('layouts.app')

@section('title', 'Edit Katalog — Karsa Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="max-w-3xl mx-auto">
        <div class="mb-10">
            <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Admin</span>
            <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">
                Edit <span class="font-normal text-zinc-400">Katalog</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light max-w-2xl mt-5">
                Perbarui detail produk digital. Perubahan akan langsung tampil di katalog user.
            </p>
        </div>

        <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-lg">
            @if($errors->any())
                <div class="mb-6 rounded-lg border border-rose-900/50 bg-rose-950/30 px-4 py-3 text-xs text-rose-200">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">
                </div>

                <div>
                    <label for="slug" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">
                </div>

                <div>
                    <label for="description" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Deskripsi Produk</label>
                    <textarea name="description" id="description" rows="5" required class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">{{ old('description', $product->description) }}</textarea>
                </div>

                <div>
                    <label for="price" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Harga</label>
                    <input type="number" name="price" id="price" value="{{ old('price', (int) $product->price) }}" required min="0" step="1000" class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="image" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Upload Gambar Baru</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-xs text-zinc-300 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-zinc-950">
                    </div>

                    <div>
                        <label for="image_path" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Path Gambar</label>
                        <input type="text" name="image_path" id="image_path" value="{{ old('image_path', $product->image_path) }}" class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg border border-zinc-900 bg-zinc-900/40">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="aspect-[16/9] w-full object-cover">
                </div>

                <div>
                    <label for="download_url" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">URL Download</label>
                    <input type="url" name="download_url" id="download_url" value="{{ old('download_url', $product->download_url) }}" required class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors">
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="flex-1 text-center bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-semibold py-3.5 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
