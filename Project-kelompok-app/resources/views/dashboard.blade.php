@extends('layouts.app')

@section('title', 'Dashboard — Karsa Studio')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-12 items-center min-h-[58vh]">
        <section>
            <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Dashboard</span>
            <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-white mt-4 mb-6 leading-tight">
                Ruang awal untuk karya digital <span class="font-normal text-zinc-400">yang lebih fokus</span>.
            </h1>
            <p class="text-zinc-400 text-sm leading-relaxed tracking-wide font-light max-w-2xl">
                Karsa Studio adalah toko asset digital premium untuk pengguna yang ingin membuat workspace lebih bersih, rapi, dan nyaman dipakai setiap hari. Koleksinya berisi wallpaper, icon pack, template Notion, dan journal digital dengan estetika minimalis.
            </p>
            <p class="text-zinc-500 text-xs leading-relaxed tracking-wide font-light max-w-2xl mt-4">
                Dashboard ini membantu Anda melihat status akun, memahami alur pembelian, lalu masuk ke katalog ketika sudah siap memilih produk.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('store') }}" class="inline-flex justify-center bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 px-6 rounded-lg tracking-widest transition-all duration-200 uppercase">
                    Masuk ke Katalog
                </a>

                @guest
                    <a href="{{ route('login') }}" class="inline-flex justify-center bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-semibold py-3.5 px-6 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                        Login Akun
                    </a>
                @else
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-semibold py-3.5 px-6 rounded-lg border border-zinc-800 tracking-widest transition-all duration-200 uppercase">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </section>

        <section class="border border-zinc-900 bg-zinc-950 p-8 rounded-2xl">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-5 mb-6">
                <div>
                    <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold">Status Akun</p>
                    <h2 class="text-lg font-medium text-white mt-1">
                        @auth
                            {{ auth()->user()->name }}
                        @else
                            Guest
                        @endauth
                    </h2>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-medium border {{ auth()->check() ? 'bg-emerald-950/40 text-emerald-400 border-emerald-900/50' : 'bg-zinc-900 text-zinc-400 border-zinc-800' }}">
                    {{ auth()->check() ? 'LOGIN' : 'BELUM LOGIN' }}
                </span>
            </div>

            <div class="space-y-5">
                <div class="flex items-start gap-4">
                    <div class="h-9 w-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs text-zinc-400">1</div>
                    <div>
                        <h3 class="text-sm font-semibold tracking-wide text-white">Masuk atau daftar akun</h3>
                        <p class="text-zinc-500 text-xs leading-relaxed mt-1">Akun dipakai untuk mengisi data checkout secara otomatis.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="h-9 w-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs text-zinc-400">2</div>
                    <div>
                        <h3 class="text-sm font-semibold tracking-wide text-white">Pilih asset di katalog</h3>
                        <p class="text-zinc-500 text-xs leading-relaxed mt-1">Buka katalog setelah dari dashboard untuk melihat koleksi produk digital.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="h-9 w-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-xs text-zinc-400">3</div>
                    <div>
                        <h3 class="text-sm font-semibold tracking-wide text-white">Lanjutkan pembayaran</h3>
                        <p class="text-zinc-500 text-xs leading-relaxed mt-1">Checkout tetap aman dan hanya bisa dilakukan setelah login.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Koleksi</p>
            <h2 class="text-2xl font-light text-white">4 kategori asset</h2>
            <p class="text-zinc-500 text-xs leading-relaxed mt-3">Wallpaper, icon, Notion dashboard, dan journal untuk mendukung tampilan serta produktivitas.</p>
        </div>

        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Akses</p>
            <h2 class="text-2xl font-light text-white">Unduh setelah bayar</h2>
            <p class="text-zinc-500 text-xs leading-relaxed mt-3">Produk digital dapat diakses melalui halaman status setelah pembayaran berhasil diverifikasi.</p>
        </div>

        <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
            <p class="text-[10px] tracking-widest uppercase text-zinc-500 font-semibold mb-3">Akun</p>
            <h2 class="text-2xl font-light text-white">Checkout lebih cepat</h2>
            <p class="text-zinc-500 text-xs leading-relaxed mt-3">Nama dan email akun dipakai otomatis saat checkout agar proses pembelian lebih ringkas.</p>
        </div>
    </section>

    <section class="mt-20 border-t border-zinc-900 pt-14">
        <div class="max-w-2xl">
            <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Tentang Karsa Studio</span>
            <h2 class="text-3xl font-light text-white mt-3 mb-5">Asset digital yang dibuat untuk workspace modern.</h2>
            <p class="text-zinc-400 text-sm leading-relaxed font-light">
                Karsa Studio berfokus pada produk digital yang sederhana, estetis, dan langsung bisa dipakai. Setiap produk dirancang agar tidak hanya terlihat bagus, tetapi juga membantu pengguna membangun lingkungan kerja yang tenang dan terstruktur.
            </p>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
                <h3 class="text-sm font-semibold tracking-wide text-white mb-2">Untuk siapa?</h3>
                <p class="text-zinc-500 text-xs leading-relaxed">Cocok untuk pelajar, kreator, developer, freelancer, dan siapa pun yang ingin desktop, ponsel, atau sistem catatannya terasa lebih tertata.</p>
            </div>

            <div class="border border-zinc-900 bg-zinc-950 p-6 rounded-2xl">
                <h3 class="text-sm font-semibold tracking-wide text-white mb-2">Cara mulai</h3>
                <p class="text-zinc-500 text-xs leading-relaxed">Masuk ke katalog, buka detail produk, baca informasi produk, lalu lanjutkan checkout hanya jika produk tersebut sesuai kebutuhan Anda.</p>
            </div>
        </div>
    </section>
</div>
@endsection
