<!DOCTYPE html>
<html lang="id" class="h-full bg-[#fbf9f5]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    
    @php
        $ogTitle = $store->name . ' — Profil Toko & Menu';
        $ogDescription = $store->tagline ?: ($store->description ?: 'Lihat daftar menu lengkap, harga terbaru, dan info jam buka ' . $store->name . ' di sini.');
        $ogUrl = route('stores.show', $store->slug);
    @endphp

    <title>{{ $ogTitle }}</title>
    <meta name="description" content="{{ $ogDescription }}">

    <!-- Open Graph / WhatsApp / Facebook / Telegram Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="QRToko">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    @if($store->logo_url)
        <meta property="og:image" content="{{ $store->logo_url }}">
        <meta property="og:image:secure_url" content="{{ $store->logo_url }}">
    @endif

    <!-- Twitter / X Sharing -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    @if($store->logo_url)
        <meta name="twitter:image" content="{{ $store->logo_url }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-full pb-16 text-stone-800 antialiased selection:bg-amber-800 selection:text-white bg-[#fbf9f5]">

    <!-- Responsive Container: Mobile-friendly (full-width/max-md on small) to 2-Column on Tablet/Desktop (max-w-6xl) -->
    <div class="max-w-6xl mx-auto px-0 sm:px-4 md:px-6 lg:px-8 py-0 sm:py-6 md:py-8">
        
        <div class="flex flex-col md:flex-row md:items-start gap-6 lg:gap-8">

            <!-- LEFT COLUMN: Store Profile, Info, Quick Links & QR (Sticky on Tablet/Desktop) -->
            <div class="w-full md:w-5/12 lg:w-4/12 md:sticky md:top-6 space-y-4">
                
                <!-- Main Profile Card -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xs border border-[#e8e2d4] overflow-hidden">
                    
                    <!-- Thin Announcement Strip (Subtle & Not Dominating) -->
                    @if($store->announcement)
                        <div class="bg-[#2a170e] text-[#f2e7d5] px-4 py-2 text-[11px] font-medium flex items-center gap-2 border-b border-[#3d2417]">
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-[#b47b2b] text-[#24160e] shrink-0">Info</span>
                            <span class="truncate leading-tight text-stone-200">{{ $store->announcement }}</span>
                        </div>
                    @endif

                    <!-- Store Header (Solid Dark Espresso / Classic 90s) -->
                    <div class="bg-[#24160e] text-white p-5 sm:p-6 rounded-b-2xl sm:rounded-b-3xl border-b border-[#3d2719]">
                        
                        <!-- Top Bar: Simple Operational Status & Utilities -->
                        <div class="flex items-center justify-between mb-4">
                            <!-- Simplified Status Indicator -->
                            <div class="inline-flex items-center gap-1.5 text-xs font-medium">
                                <span class="w-2 h-2 rounded-full {{ $store->is_open ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                <span class="{{ $store->is_open ? 'text-emerald-300' : 'text-rose-300' }}">
                                    {{ $store->is_open ? 'Buka Hari Ini' : 'Tutup Sementara' }}
                                </span>
                            </div>

                            <!-- Quiet Utilities: Home, QR Modal, Owner Edit -->
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('home') }}" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-stone-200 transition-colors" title="Kembali ke Beranda QRToko">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </a>
                                <button type="button" onclick="openQrModal()" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-stone-200 transition-colors cursor-pointer" title="Tampilkan QR Code Toko">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </button>
                                @if(Auth::check() && ($store->user_id === Auth::id() || $store->user_id === null))
                                    <a href="{{ route('stores.edit', $store->slug) }}" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-stone-200 transition-colors" title="Kelola Toko (Khusus Pemilik)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Store Logo & Identity (Balanced Proportions) -->
                        <div class="flex items-center gap-3.5 sm:gap-4">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-[#faf6ee] flex items-center justify-center shrink-0 border border-stone-600/60 overflow-hidden shadow-xs">
                                @if($store->logo_url)
                                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[#24160e] font-black text-2xl">{{ strtoupper(substr($store->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] sm:text-[11px] font-bold text-[#d4af7a] tracking-wider uppercase block">{{ $store->category }}</span>
                                <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white leading-tight truncate mt-0.5">{{ $store->name }}</h1>
                                @if($store->tagline)
                                    <p class="text-xs text-stone-300 italic mt-0.5 truncate font-normal">"{{ $store->tagline }}"</p>
                                @endif
                            </div>
                        </div>

                        <!-- 3 Primary Contact Buttons (WhatsApp, Lokasi, Instagram) - Super Mini & Compact -->
                        <div class="grid grid-cols-3 gap-2 sm:gap-2.5 mt-4">
                            <!-- 1. WhatsApp Direct -->
                            <a href="https://wa.me/{{ $store->formatted_phone }}?text=Halo%20{{ urlencode($store->name) }},%20saya%20ingin%20tanya-tanya" target="_blank" class="group flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-stone-200 hover:text-white border border-white/10 hover:border-[#d4af7a]/40 shadow-xs transition-all text-center">
                                <img src="{{ asset('icons/retro/whatsapp.png') }}" class="w-5 h-5 object-contain mb-1 drop-shadow-sm group-hover:scale-105 transition-transform" alt="WhatsApp">
                                <span class="text-[10px] font-semibold tracking-tight leading-tight">WhatsApp</span>
                            </a>

                            <!-- 2. Google Maps -->
                            @if($store->maps_url)
                                <a href="{{ $store->maps_url }}" target="_blank" class="group flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-stone-200 hover:text-white border border-white/10 hover:border-[#d4af7a]/40 shadow-xs transition-all text-center">
                                    <img src="{{ asset('icons/retro/lokasi.png') }}" class="w-5 h-5 object-contain mb-1 drop-shadow-sm group-hover:scale-105 transition-transform" alt="Lokasi">
                                    <span class="text-[10px] font-semibold tracking-tight leading-tight">Lokasi</span>
                                </a>
                            @else
                                <div class="flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.03] border border-white/5 text-stone-500 text-center opacity-50">
                                    <img src="{{ asset('icons/retro/lokasi.png') }}" class="w-5 h-5 object-contain mb-1 grayscale opacity-40" alt="Lokasi">
                                    <span class="text-[10px] font-medium text-stone-500 leading-tight">Lokasi</span>
                                </div>
                            @endif

                            <!-- 3. Instagram (or Telepon fallback) -->
                            @if($store->instagram)
                                <a href="https://instagram.com/{{ ltrim($store->instagram, '@') }}" target="_blank" class="group flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-stone-200 hover:text-white border border-white/10 hover:border-[#d4af7a]/40 shadow-xs transition-all text-center">
                                    <img src="{{ asset('icons/retro/instagram.png') }}" class="w-5 h-5 object-contain mb-1 drop-shadow-sm group-hover:scale-105 transition-transform" alt="Instagram">
                                    <span class="text-[10px] font-semibold tracking-tight leading-tight">Instagram</span>
                                </a>
                            @elseif($store->phone)
                                <a href="tel:{{ $store->formatted_phone }}" class="group flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-stone-200 hover:text-white border border-white/10 hover:border-[#d4af7a]/40 shadow-xs transition-all text-center">
                                    <img src="{{ asset('icons/retro/telepon.png') }}" class="w-5 h-5 object-contain mb-1 drop-shadow-sm group-hover:scale-105 transition-transform" alt="Telepon">
                                    <span class="text-[10px] font-semibold tracking-tight leading-tight">Telepon</span>
                                </a>
                            @else
                                <div class="flex flex-col items-center justify-center py-1.5 px-1 rounded-xl bg-white/[0.03] border border-white/5 text-stone-500 text-center opacity-50">
                                    <img src="{{ asset('icons/retro/instagram.png') }}" class="w-5 h-5 object-contain mb-1 grayscale opacity-40" alt="Instagram">
                                    <span class="text-[10px] font-medium text-stone-500 leading-tight">Instagram</span>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Store Information List (Clean, Natural, No Heavy Dashboard Cards) -->
                    <div class="p-5 sm:p-6 space-y-4 text-xs text-stone-600 bg-white">
                        
                        <!-- Jam Operasional -->
                        @if($store->opening_hours)
                            <div class="flex items-start gap-3">
                                <img src="{{ asset('icons/retro/jam-operasional.png') }}" class="w-4 h-4 mt-0.5 object-contain shrink-0" alt="">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block">Jam Operasional</span>
                                    <span class="text-stone-800 text-xs font-semibold leading-relaxed">{{ $store->opening_hours }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Alamat Toko -->
                        @if($store->address)
                            <div class="flex items-start gap-3">
                                <img src="{{ asset('icons/retro/lokasi.png') }}" class="w-4 h-4 mt-0.5 object-contain shrink-0" alt="">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block">Alamat Toko</span>
                                    <span class="text-stone-800 text-xs font-medium leading-relaxed">{{ $store->address }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Tentang Toko -->
                        @if($store->description)
                            <div class="pt-3 border-t border-stone-100">
                                <div class="flex items-center gap-1.5 text-stone-800 mb-1">
                                    <img src="{{ asset('icons/retro/tentang.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Tentang Toko</span>
                                </div>
                                <p class="text-stone-700 text-xs leading-relaxed">
                                    {{ $store->description }}
                                </p>
                            </div>
                        @endif

                        <!-- Fasilitas & Layanan (Consistent Chips) -->
                        @if(!empty($store->facilities))
                            <div class="pt-3 border-t border-stone-100 space-y-2">
                                <div class="flex items-center gap-1.5">
                                    <img src="{{ asset('icons/retro/fasilitas.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Fasilitas & Layanan</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($store->facilities as $fac)
                                        @php
                                            $cleanFac = trim(preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{1F900}-\x{1F9FF}\x{1F018}-\x{1F0F5}\x{1F200}-\x{1F270}\x{2300}-\x{23FF}\x{2B50}\x{200D}]/u', '', $fac));
                                            $facLower = strtolower($fac);
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#f8f5ee] text-stone-800 text-[11px] font-medium border border-[#e8e2d4]">
                                            @if(str_contains($facLower, 'wifi') || str_contains($facLower, 'wi-fi'))
                                                <img src="{{ asset('icons/retro/wifi.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="WiFi">
                                            @elseif(str_contains($facLower, 'parkir') || str_contains($facLower, 'mobil') || str_contains($facLower, 'motor'))
                                                <img src="{{ asset('icons/retro/parkir.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="Parkir">
                                            @elseif(str_contains($facLower, 'qris') || str_contains($facLower, 'bayar') || str_contains($facLower, 'kartu'))
                                                <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="QRIS">
                                            @else
                                                <img src="{{ asset('icons/retro/info.png') }}" class="w-3.5 h-3.5 object-contain shrink-0" alt="">
                                            @endif
                                            <span>{{ $cleanFac ?: $fac }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Secondary Utilities: Bagi QR & Standee Meja -->
                        <div class="pt-3 border-t border-stone-100 flex items-center gap-2">
                            <button type="button" onclick="openQrModal()" class="flex-1 py-2 px-3 rounded-xl border border-stone-200 hover:bg-[#faf7f2] text-stone-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-4 h-4 object-contain" alt="">
                                <span>Bagi QR Toko</span>
                            </button>
                            <a href="{{ route('stores.qr', $store->slug) }}" class="flex-1 py-2 px-3 rounded-xl bg-[#24160e] hover:bg-[#1a0f09] text-[#f7f2ea] text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors shadow-2xs">
                                <span>Cetak Standee</span>
                            </a>
                        </div>

                    </div>

                </div>

                <!-- Desktop / Tablet QR Box helper (Hidden on small mobile screens, visible on md+) -->
                <div class="hidden md:block bg-white rounded-2xl sm:rounded-3xl p-5 border border-[#e8e2d4] shadow-xs text-center space-y-3">
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-stone-700">
                        <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-4 h-4 object-contain shrink-0" alt="QR Scan">
                        <span>Buka Menu di Ponsel</span>
                    </div>
                    <div id="desktop-qrcode" class="flex justify-center p-3 bg-[#faf7f2] rounded-xl border border-stone-200/80"></div>
                    <p class="text-[11px] text-stone-400">Scan QR Code di atas menggunakan kamera HP untuk membuka menu ini.</p>
                </div>

            </div>

            <!-- RIGHT COLUMN: Menu Section -->
            <div class="w-full md:w-7/12 lg:w-8/12 px-4 sm:px-0 space-y-4">
                
                <div class="space-y-3">
                    <!-- Section Header (Bold, Clear, Human) -->
                    <div class="flex items-center justify-between pb-3 border-b border-[#e5decb]">
                        <h2 class="text-lg sm:text-xl font-black tracking-tight text-[#24160e] flex items-center gap-2">
                            <img src="{{ asset('icons/retro/menu.png') }}" class="w-6 h-6 object-contain shrink-0" alt="">
                            <span>Daftar Menu & Harga</span>
                        </h2>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-[#f4efe8] text-stone-700 border border-[#e5decb]">
                            <span id="product-count-badge" class="font-bold text-[#24160e]">{{ $products->flatten()->count() }}</span> Pilihan
                        </span>
                    </div>

                    @if($products->isNotEmpty())
                        <!-- Minimalist Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="menu-search-input" 
                                placeholder="Cari menu, minuman, camilan..." 
                                class="w-full pl-10 pr-9 py-2 rounded-xl bg-white border border-[#e5decb] text-xs sm:text-sm text-stone-800 placeholder-stone-400 shadow-2xs focus:outline-none focus:border-[#7c5e43] transition-colors"
                            >
                            <button 
                                type="button" 
                                id="menu-search-clear" 
                                onclick="clearMenuSearch()" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700 hidden transition-colors cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Sticky Category Pills Bar (Simple & Tactile) -->
                        <div class="sticky top-0 z-20 -mx-4 px-4 sm:mx-0 sm:px-0 py-2 bg-[#fbf9f5]/95 backdrop-blur-xs">
                            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar scroll-smooth">
                                <button 
                                    type="button" 
                                    onclick="filterByCategory('all', this)" 
                                    class="category-pill active whitespace-nowrap px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 bg-[#24160e] text-[#f7f2ea] shadow-2xs cursor-pointer"
                                >
                                    Semua ({{ $products->flatten()->count() }})
                                </button>
                                @foreach($products as $category => $items)
                                    <button 
                                        type="button" 
                                        onclick="filterByCategory('{{ Str::slug($category) }}', this)" 
                                        class="category-pill whitespace-nowrap px-3.5 py-1.5 rounded-xl text-xs font-medium transition-all shrink-0 bg-white hover:bg-[#faf7f2] text-stone-700 border border-[#e5decb] shadow-2xs hover:text-stone-900 cursor-pointer"
                                    >
                                        {{ $category }} ({{ $items->count() }})
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-16 px-4 bg-white rounded-2xl border border-dashed border-[#e5decb] space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-[#faf7f2] flex items-center justify-center text-stone-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <p class="text-xs text-stone-500 font-medium">Daftar menu untuk toko ini sedang disiapkan.</p>
                        @if(Auth::check() && ($store->user_id === Auth::id() || $store->user_id === null))
                            <a href="{{ route('stores.edit', $store->slug) }}" class="inline-block mt-2 px-4 py-2 rounded-xl bg-[#24160e] text-[#f7f2ea] text-xs font-bold shadow-2xs">
                                + Tambah Menu Sekarang
                            </a>
                        @endif
                    </div>
                @else
                    <!-- No search results state (hidden by default) -->
                    <div id="no-search-results" class="hidden text-center py-14 px-4 bg-white rounded-2xl border border-dashed border-[#e5decb] space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-[#faf7f2] flex items-center justify-center text-stone-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-stone-800">Menu tidak ditemukan</p>
                            <p class="text-xs text-stone-500 mt-0.5">Coba gunakan kata kunci pencarian menu lainnya.</p>
                        </div>
                        <button type="button" onclick="clearMenuSearch()" class="px-4 py-2 rounded-xl bg-[#faf7f2] hover:bg-[#f3ede3] text-stone-700 text-xs font-semibold transition-all cursor-pointer">
                            Tampilkan Semua Menu
                        </button>
                    </div>

                    <!-- Categories Sections -->
                    <div class="space-y-8" id="menu-categories-container">
                        @foreach($products as $category => $items)
                            <div class="category-section space-y-3" data-category-slug="{{ Str::slug($category) }}">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#1b4332]"></span>
                                    <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-800">{{ $category }}</h3>
                                    <span class="text-[11px] font-medium text-stone-400">({{ $items->count() }})</span>
                                    <span class="h-px bg-[#e5decb] flex-1 ml-2"></span>
                                </div>

                                <!-- Responsive Grid: 1 col on small phones, 2 cols on tablets & laptops -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    @foreach($items as $product)
                                        <div 
                                            class="menu-card group relative bg-white rounded-2xl p-3.5 sm:p-4 border border-[#e8e2d4] hover:border-[#b47b2b]/70 hover:shadow-xs transition-all cursor-pointer flex flex-col justify-between"
                                            data-name="{{ strtolower($product->name) }}"
                                            data-desc="{{ strtolower($product->description ?? '') }}"
                                            data-category="{{ Str::slug($category) }}"
                                            onclick="openProductDetail(this)"
                                            id="product-card-{{ $product->id }}"
                                        >
                                            <div class="flex items-start gap-3 sm:gap-3.5">
                                                @if($product->image_url_formatted)
                                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-stone-100 overflow-hidden shrink-0 border border-stone-200/80 shadow-2xs relative">
                                                        <img src="{{ $product->image_url_formatted }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-[#f8f5ee] border border-[#e8e2d4] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                                        <img src="{{ asset('icons/retro/menu.png') }}" class="w-6 h-6 object-contain opacity-75 group-hover:opacity-100 transition-opacity" alt="Menu">
                                                    </div>
                                                @endif

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <h4 class="text-sm font-bold text-stone-900 group-hover:text-[#24160e] transition-colors leading-snug line-clamp-1">
                                                            {{ $product->name }}
                                                        </h4>
                                                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-md bg-[#f8f5ee] text-stone-600 border border-[#e8e2d4] shrink-0">
                                                            Tersedia
                                                        </span>
                                                    </div>
                                                    @if($product->description)
                                                        <p class="text-[11px] text-stone-500 mt-1 line-clamp-2 leading-relaxed">
                                                            {{ $product->description }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-2.5 border-t border-stone-100 flex items-center justify-between">
                                                <span class="text-sm sm:text-base font-extrabold text-[#1b4332] tracking-tight">
                                                    {{ $product->formatted_price }}
                                                </span>
                                                <span class="text-[11px] font-medium text-stone-400 group-hover:text-[#24160e] transition-colors inline-flex items-center gap-1">
                                                    <span>Detail</span>
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </span>
                                            </div>

                                            @php
                                                $productJson = json_encode([
                                                    'name' => $product->name,
                                                    'category' => $category,
                                                    'price' => $product->formatted_price,
                                                    'description' => $product->description ?? 'Tidak ada deskripsi tambahan untuk menu ini.',
                                                    'image' => $product->image_url_formatted ?? ''
                                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                            @endphp
                                            <template class="product-data">{!! $productJson !!}</template>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Page Footer Info & Viral CTA -->
                <div class="pt-10 pb-4 text-center text-xs text-stone-500 space-y-2 border-t border-[#e8e2d4]">
                    <p>Halaman info dan menu digital ini dibuat dengan <a href="{{ route('home') }}" class="font-bold text-[#1b4332] hover:underline">QRToko</a></p>
                    <p class="text-[11px] text-stone-500">Punya warung, kafe, atau toko sendiri? <a href="{{ route('stores.create') }}" class="text-[#1b4332] font-bold underline hover:text-[#24160e]">Buat QR Tokomu Gratis Sekarang →</a></p>
                </div>

            </div>

        </div>

    </div>

    <!-- QR Modal -->
    <div id="qr-modal" class="fixed inset-0 z-50 bg-[#140b06]/75 flex items-center justify-center p-4 hidden">
        <div class="bg-[#fbf9f5] rounded-2xl max-w-sm w-full p-6 text-center shadow-xl border border-[#e8e2d4] relative">
            <button type="button" onclick="closeQrModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#f0eae1] hover:bg-[#e6ddce] text-stone-600 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="flex items-center justify-center gap-2 mb-1">
                <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-6 h-6 rounded-lg object-contain shrink-0" alt="QR Code">
                <h3 class="text-base font-bold text-stone-900">QR Code Toko</h3>
            </div>
            <p class="text-xs text-stone-500 mb-4">{{ $store->name }}</p>

            <div class="bg-white p-4 rounded-xl inline-block border border-[#e8e2d4] mx-auto shadow-2xs">
                <div id="qrcode-canvas" class="flex justify-center"></div>
            </div>

            <p class="text-[11px] text-stone-500 mt-3">Scan kamera HP untuk langsung membuka halaman ini.</p>

            <div class="flex gap-2 mt-5">
                <button type="button" onclick="copyStoreUrl()" class="flex-1 py-2.5 rounded-xl border border-[#dcd4c5] bg-white hover:bg-[#faf7f2] text-stone-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors">
                    <img src="{{ asset('icons/retro/bagikan.png') }}" class="w-4 h-4 rounded-xs object-contain shrink-0" alt="Bagikan">
                    <span>Salin Link</span>
                </button>
                <a href="{{ route('stores.qr', $store->slug) }}" class="flex-1 py-2.5 rounded-xl bg-[#1b4332] hover:bg-[#143326] text-[#f7f3eb] text-xs font-semibold flex items-center justify-center gap-1.5 shadow-2xs transition-colors">
                    <span>Cetak QR Meja</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal (Classic Aesthetic Preview) -->
    <div id="product-modal" class="fixed inset-0 z-50 bg-[#140b06]/75 flex items-center justify-center p-4 hidden">
        <div class="bg-[#fbf9f5] rounded-2xl max-w-sm w-full overflow-hidden shadow-xl border border-[#e8e2d4] relative">
            <!-- Close Button -->
            <button type="button" onclick="closeProductModal()" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-stone-900/70 hover:bg-stone-900 text-white flex items-center justify-center transition-all" title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Product Image Container -->
            <div id="modal-image-container" class="w-full h-52 bg-stone-100 relative overflow-hidden hidden border-b border-[#e8e2d4]">
                <img id="modal-product-image" src="" alt="" class="w-full h-full object-cover">
            </div>

            <!-- Content -->
            <div class="p-5 sm:p-6 space-y-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span id="modal-product-category" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-[#f0eae1] text-stone-700 uppercase tracking-wider border border-[#e2d9cb]"></span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-md bg-[#f0eae1] text-stone-700 border border-[#e2d9cb]">Tersedia</span>
                    </div>
                    <h3 id="modal-product-name" class="text-base sm:text-lg font-bold text-stone-900 leading-tight"></h3>
                    <p id="modal-product-price" class="text-base sm:text-lg font-extrabold text-[#1b4332] mt-2"></p>
                </div>

                <div class="pt-3 border-t border-[#e8e2d4] space-y-1">
                    <h4 class="text-[10px] font-bold uppercase tracking-wider text-stone-500">Keterangan Menu:</h4>
                    <p id="modal-product-desc" class="text-xs sm:text-sm text-stone-700 leading-relaxed"></p>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="closeProductModal()" class="w-full py-2.5 rounded-xl bg-[#24160e] hover:bg-[#382317] text-[#f7f2ea] text-xs font-semibold transition-all shadow-2xs cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-Side Scripts (QR + Menu UX Search & Filters) -->
    <script>
        const storeUrl = window.location.href;

        // QR Code Modal handling
        let qrGenerated = false;
        function openQrModal() {
            document.getElementById('qr-modal').classList.remove('hidden');
            if (!qrGenerated) {
                new QRCode(document.getElementById("qrcode-canvas"), {
                    text: storeUrl,
                    width: 180,
                    height: 180,
                    colorDark : "#1c1917",
                    colorLight : "#faf7f2",
                    correctLevel : QRCode.CorrectLevel.H
                });
                qrGenerated = true;
            }
        }

        function closeQrModal() {
            document.getElementById('qr-modal').classList.add('hidden');
        }

        function copyStoreUrl() {
            navigator.clipboard.writeText(storeUrl).then(() => {
                alert('Tautan toko berhasil disalin!');
            });
        }

        // Desktop QR render
        const desktopBox = document.getElementById("desktop-qrcode");
        if (desktopBox) {
            new QRCode(desktopBox, {
                text: storeUrl,
                width: 140,
                height: 140,
                colorDark : "#1c1917",
                colorLight : "#faf7f2",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // Menu Filter & Live Search Logic
        let currentCategory = 'all';

        function filterByCategory(slug, button) {
            currentCategory = slug;

            document.querySelectorAll('.category-pill').forEach(btn => {
                btn.classList.remove('active', 'bg-[#24160e]', 'text-[#f7f2ea]', 'font-bold');
                btn.classList.add('bg-white', 'text-stone-700', 'border', 'border-[#e5decb]', 'font-medium');
            });

            button.classList.add('active', 'bg-[#24160e]', 'text-[#f7f2ea]', 'font-bold');
            button.classList.remove('bg-white', 'text-stone-700', 'border', 'border-[#e5decb]', 'font-medium');

            applyMenuFilters();
        }

        function applyMenuFilters() {
            const searchInput = document.getElementById('menu-search-input');
            const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
            const clearBtn = document.getElementById('menu-search-clear');
            if (clearBtn) {
                clearBtn.classList.toggle('hidden', query === '');
            }

            let totalVisible = 0;

            document.querySelectorAll('.category-section').forEach(section => {
                const sectionCategory = section.getAttribute('data-category-slug');
                let categoryVisibleCount = 0;

                const cards = section.querySelectorAll('.menu-card');
                cards.forEach(card => {
                    const cardName = card.getAttribute('data-name') || '';
                    const cardDesc = card.getAttribute('data-desc') || '';

                    const matchesCategory = (currentCategory === 'all' || sectionCategory === currentCategory);
                    const matchesQuery = query === '' || cardName.includes(query) || cardDesc.includes(query);

                    if (matchesCategory && matchesQuery) {
                        card.classList.remove('hidden');
                        categoryVisibleCount++;
                        totalVisible++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (categoryVisibleCount > 0) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });

            const badge = document.getElementById('product-count-badge');
            if (badge) {
                badge.textContent = totalVisible;
            }

            const emptyState = document.getElementById('no-search-results');
            if (emptyState) {
                emptyState.classList.toggle('hidden', totalVisible > 0);
            }
        }

        document.getElementById('menu-search-input')?.addEventListener('input', applyMenuFilters);

        function clearMenuSearch() {
            const input = document.getElementById('menu-search-input');
            if (input) {
                input.value = '';
            }
            applyMenuFilters();
        }

        // Product Detail Modal Handling
        function openProductDetail(card) {
            const tpl = card.querySelector('template.product-data');
            if (!tpl) return;
            try {
                const data = JSON.parse(tpl.innerHTML);
                document.getElementById('modal-product-name').textContent = data.name;
                document.getElementById('modal-product-category').textContent = data.category;
                document.getElementById('modal-product-price').textContent = data.price;
                document.getElementById('modal-product-desc').textContent = data.description;

                const imgContainer = document.getElementById('modal-image-container');
                const img = document.getElementById('modal-product-image');
                if (data.image) {
                    img.src = data.image;
                    img.alt = data.name;
                    imgContainer.classList.remove('hidden');
                } else {
                    imgContainer.classList.add('hidden');
                }

                document.getElementById('product-modal').classList.remove('hidden');
            } catch (e) {
                console.error(e);
            }
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.add('hidden');
        }

        // Close on clicking backdrop
        document.getElementById('product-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });
        document.getElementById('qr-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeQrModal();
            }
        });
    </script>
</body>
</html>
