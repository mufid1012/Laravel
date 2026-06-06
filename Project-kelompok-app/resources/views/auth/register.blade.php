@extends('layouts.app')

@section('title', 'Register — Karsa Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="max-w-md mx-auto">
    <div class="mb-10 text-center">
        <span class="inline-flex items-center rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-zinc-500">Akun Baru</span>
        <h1 class="text-5xl md:text-6xl font-extralight tracking-tight text-white mt-6 leading-[1.05]">Register</h1>
        <p class="text-zinc-400 text-sm mt-5 leading-relaxed">Buat akun untuk checkout, menyimpan riwayat order, dan membuka status pembelian digital Anda.</p>
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

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Contoh: John Doe"
                    class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div>
                <label for="email" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="nama@email.com"
                    class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div>
                <label for="password" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    placeholder="Minimal 8 karakter"
                    class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    placeholder="Ulangi password"
                    class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-zinc-500 transition-colors"
                >
            </div>

            <button type="submit" class="w-full bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase">
                Register
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-zinc-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-zinc-200 hover:text-white font-medium">Login di sini</a>
        </p>
    </div>
    </div>
</div>
@endsection
