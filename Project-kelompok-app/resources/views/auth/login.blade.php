@extends('layouts.app')

@section('title', 'Login — Karsa Studio')

@section('content')
<div class="max-w-md mx-auto px-6 py-16">
    <div class="mb-10 text-center">
        <span class="text-[10px] tracking-[0.25em] uppercase text-zinc-500 font-semibold">Masuk Akun</span>
        <h1 class="text-3xl font-light text-white tracking-wide mt-2">Login</h1>
        <p class="text-zinc-500 text-xs mt-3 leading-relaxed">Masuk untuk melanjutkan checkout dan mengakses pembelian Anda.</p>
    </div>

    <div class="border border-zinc-900 bg-zinc-950 p-8 rounded-2xl">
        @if($errors->any())
            <div class="mb-6 rounded-lg border border-rose-900/50 bg-rose-950/30 px-4 py-3 text-xs text-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-[10px] tracking-wider uppercase text-zinc-400 font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
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

            <label class="flex items-center gap-3 text-xs text-zinc-400">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-zinc-700 bg-zinc-900 text-zinc-50 focus:ring-zinc-500">
                Ingat saya
            </label>

            <button type="submit" class="w-full bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-3.5 rounded-lg tracking-widest transition-all duration-200 uppercase">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-zinc-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-zinc-200 hover:text-white font-medium">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
