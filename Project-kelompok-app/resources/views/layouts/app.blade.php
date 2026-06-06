<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karsa Studio — Premium Digital Assets')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b; /* Zinc 950 */
            color: #fafafa; /* Zinc 50 */
        }
        
        /* Smooth selection colors */
        ::selection {
            background-color: rgba(250, 250, 250, 0.1);
            color: #ffffff;
        }

        /* Modern minimalist scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b;
        }
        ::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col selection:bg-zinc-800 selection:text-white">
    
    <!-- Top Decorative Gradient Line -->
    <div class="h-1 w-full bg-gradient-to-r from-zinc-800 via-zinc-400 to-zinc-800"></div>

    <!-- Navigation Header -->
    <header class="border-b border-zinc-900 bg-zinc-950/50 backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-5xl mx-auto px-6 py-5 md:h-20 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0">
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-3">
                <span class="font-light tracking-[0.25em] text-lg text-white group-hover:text-zinc-300 transition-colors">
                    KARSA<span class="font-semibold text-zinc-400">STUDIO</span>
                </span>
            </a>
            
            <nav class="flex flex-wrap items-center justify-center gap-4 md:gap-8">
                <a href="{{ route('dashboard') }}" class="text-xs tracking-widest text-zinc-400 hover:text-white transition-colors">
                    DASHBOARD
                </a>
                <a href="{{ route('store') }}" class="text-xs tracking-widest text-zinc-400 hover:text-white transition-colors">
                    KATALOG
                </a>
                <a href="https://github.com" target="_blank" class="text-xs tracking-widest text-zinc-400 hover:text-white transition-colors">
                    DOKUMENTASI
                </a>

                @auth
                    <span class="hidden md:inline text-xs tracking-widest text-zinc-500">
                        {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs tracking-widest text-zinc-400 hover:text-white transition-colors">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs tracking-widest text-zinc-400 hover:text-white transition-colors">
                        LOGIN
                    </a>
                    <a href="{{ route('register') }}" class="bg-zinc-50 hover:bg-zinc-200 text-zinc-950 text-xs font-semibold py-2.5 px-4 rounded-lg tracking-widest transition-all duration-200">
                        REGISTER
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-zinc-900 bg-zinc-950/80 mt-20">
        <div class="max-w-5xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-zinc-500 text-xs tracking-wider">
                &copy; {{ date('Y') }} Karsa Studio. All rights reserved.
            </div>
            <div class="flex gap-8">
                <a href="#" class="text-zinc-500 hover:text-zinc-300 text-xs tracking-wider transition-colors">Privacy</a>
                <a href="#" class="text-zinc-500 hover:text-zinc-300 text-xs tracking-wider transition-colors">Terms of Service</a>
                <a href="#" class="text-zinc-500 hover:text-zinc-300 text-xs tracking-wider transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
