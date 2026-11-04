<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Standee — {{ $store->name }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-card { box-shadow: none !important; border: 2px solid #000 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4 flex flex-col items-center justify-center">

    <!-- Top Action Bar (hidden on print) -->
    <div class="no-print max-w-md w-full mb-6 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-xs font-semibold">
            <a href="{{ route('stores.show', $store->slug) }}" class="text-slate-600 hover:text-emerald-600 flex items-center gap-1">
                <span>←</span>
                <span>Halaman Toko</span>
            </a>
            @if(Auth::check() && ($store->user_id === Auth::id() || $store->user_id === null))
                <span class="text-slate-300">|</span>
                <a href="{{ route('stores.edit', $store->slug) }}" class="text-slate-600 hover:text-emerald-600">
                    Kelola
                </a>
            @endif
        </div>

        <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-2 shadow-md shadow-emerald-600/30 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Cetak Standee (Ctrl + P)</span>
        </button>
    </div>

    <!-- Printable Standee Card (A5 Ratio / Acrylic Standee Look) -->
    <div class="print-card bg-white max-w-sm w-full rounded-3xl p-8 border-2 border-slate-900 shadow-2xl text-center space-y-6 relative overflow-hidden">
        
        <!-- Top Badge -->
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold uppercase tracking-widest">
            <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-4 h-4 rounded-xs object-contain" alt="QR">
            <span>SCAN DI SINI</span>
        </div>

        @if($store->logo_url)
            <div class="w-16 h-16 rounded-2xl mx-auto overflow-hidden border border-slate-300 shadow-sm">
                <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Store Header -->
        <div class="space-y-1">
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $store->name }}</h1>
            @if($store->tagline)
                <p class="text-xs text-slate-500 font-medium italic">"{{ $store->tagline }}"</p>
            @endif
        </div>

        <!-- QR Code Canvas with High Contrast Frame -->
        <div class="p-5 rounded-2xl bg-white border-2 border-slate-200 inline-block shadow-sm">
            <div id="standee-qrcode" class="flex justify-center"></div>
        </div>

        <!-- Instructions -->
        <div class="space-y-1.5 max-w-xs mx-auto">
            <p class="text-xs font-bold text-slate-800 leading-snug">
                Buka Kamera HP untuk Melihat Menu & Jam Buka
            </p>
            <p class="text-[11px] text-slate-500 leading-relaxed">
                Scan QR Code di atas untuk melihat daftar menu lengkap, harga terbaru, dan jam operasional kami.
            </p>
        </div>

        <!-- Bottom Footer -->
        <div class="pt-4 border-t border-slate-200/80 flex items-center justify-between text-[10px] text-slate-500 font-semibold uppercase tracking-wider">
            <span>{{ $store->category }}</span>
            <span class="inline-flex items-center gap-1.5">
                <img src="{{ asset('icons/retro/telepon.png') }}" class="w-3.5 h-3.5 rounded-xs object-contain" alt="Telepon">
                <span>{{ $store->phone }}</span>
            </span>
        </div>
    </div>

    <div class="no-print mt-6 max-w-sm flex items-start gap-2 text-xs text-slate-500 bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm">
        <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="leading-relaxed">
            <strong class="text-slate-700">Tips Cetak:</strong> Kamu bisa mencetak halaman ini di kertas foto atau karton tebal, lalu pasang di akrilik meja kasir berukuran A5 atau A6.
        </p>
    </div>

    <script>
        const storeUrl = "{{ route('stores.show', $store->slug) }}";

        new QRCode(document.getElementById("standee-qrcode"), {
            text: storeUrl,
            width: 220,
            height: 220,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
