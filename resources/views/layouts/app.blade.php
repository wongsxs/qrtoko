<!DOCTYPE html>
<html lang="id" class="h-full bg-[#fbf9f5]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'QR Toko - Platform Profil & Katalog Toko Berbasis QR Code' }}</title>
    <meta name="description" content="Platform profil toko & katalog menu digital berbasis QR code untuk UMKM Indonesia. Cepat, praktis, tanpa aplikasi, dan siap cetak standee meja.">

    <!-- Open Graph / WhatsApp / Facebook Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="QRToko">
    <meta property="og:title" content="{{ $title ?? 'QR Toko - Platform Profil & Katalog Toko Berbasis QR Code' }}">
    <meta property="og:description" content="Platform profil toko & katalog menu digital berbasis QR code untuk UMKM Indonesia. Cepat, praktis, tanpa aplikasi, dan siap cetak standee meja.">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter / X Sharing -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title ?? 'QR Toko - Platform Profil & Katalog Toko Berbasis QR Code' }}">
    <meta name="twitter:description" content="Platform profil toko & katalog menu digital berbasis QR code untuk UMKM Indonesia. Cepat, praktis, tanpa aplikasi, dan siap cetak standee meja.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-stone-800 antialiased selection:bg-amber-800 selection:text-white bg-[#fbf9f5]">

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 bg-[#fbf9f5]/90 backdrop-blur-md border-b border-stone-200/90">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform bg-[#24160e] text-[#f2e7d5] p-2 shadow-xs border border-[#3d2417]">
                        <x-vintage-icon name="qr-code" class="w-full h-full text-[#d4af7a]" />
                    </div>
                    <div class="flex items-center">
                        <span class="text-base sm:text-lg font-black tracking-tight text-slate-900 group-hover:text-emerald-600 transition-colors">QRToko</span>
                        <span class="hidden sm:inline-block text-[10px] font-semibold px-1.5 py-0.5 ml-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60">v1.2</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="flex items-center gap-1.5 sm:gap-2.5">
                    <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors px-2 sm:px-3 py-1.5 rounded-lg hover:bg-slate-100">
                        <span class="hidden sm:inline">Eksplor </span>Toko
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70 transition-colors px-2.5 sm:px-3 py-1.5 rounded-xl">
                            <span class="hidden sm:inline">Toko </span>Saya
                        </a>

                        <a href="{{ route('stores.create') }}" class="inline-flex items-center gap-1 px-2.5 sm:px-3.5 py-1.5 sm:py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition-all">
                            <span>+</span>
                            <span class="hidden sm:inline">Buat Toko</span>
                            <span class="sm:hidden">Toko</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-rose-600 transition-colors p-1.5" title="Keluar">
                                <span class="hidden sm:inline">Keluar</span>
                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-emerald-600 transition-colors px-2 sm:px-3 py-1.5">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <span>Daftar</span>
                            <span class="hidden sm:inline">/ Buat Toko</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto px-4 mt-4 w-full">
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm font-medium leading-relaxed">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-4xl mx-auto px-4 mt-4 w-full">
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Ada beberapa hal yang perlu diperiksa:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-16 text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-black text-xs">Q</span>
                <p>© {{ date('Y') }} <strong>QRToko</strong> — Platform Profil Toko & Menu Digital Berbasis QR Code.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4 text-slate-600 font-medium">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                <a href="{{ route('stores.index') }}" class="hover:text-emerald-600 transition-colors">Eksplor Toko</a>
                <a href="{{ route('stores.create') }}" class="hover:text-emerald-600 transition-colors">Buat Profil Toko</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard Toko Saya</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-emerald-600 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="hover:text-emerald-600 transition-colors">Daftar</a>
                @endauth
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
