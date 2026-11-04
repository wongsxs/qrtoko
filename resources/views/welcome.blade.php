@extends('layouts.app')

@section('content')
<div class="space-y-16 py-8">
    <!-- Hero Section -->
    <section class="max-w-5xl mx-auto px-4 text-center space-y-6 pt-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-semibold shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Bikin menu & info toko dalam 1 menit
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.15]">
            Menu & info tokomu, langsung kebuka lewat <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">scan QR.</span>
        </h1>

        <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
            Gak perlu bayar mahal buat sewa programmer atau bikin website ribet. Pasang stiker QR di meja atau kasir, pelanggan cukup scan buat cek daftar harga, jam buka, dan alamat tokomu.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
            <a href="{{ route('stores.create') }}" class="w-full sm:w-auto px-8 py-3.5 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-lg shadow-emerald-600/30 hover:scale-105 active:scale-95 transition-all">
                Buat Halaman Toko Gratis
            </a>
            <a href="{{ route('stores.index') }}" class="w-full sm:w-auto px-8 py-3.5 text-base font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-2xl shadow-sm hover:shadow transition-all">
                Lihat Contoh Menu
            </a>
        </div>
    </section>

    <!-- 3 Core Steps / How it works -->
    <section class="max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Step 1 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 flex items-center justify-center">
                    <img src="{{ asset('icons/retro/profil-toko.png') }}" class="w-12 h-12 rounded-2xl object-contain drop-shadow-xs" alt="Tulis Info Toko">
                </div>
                <h3 class="text-lg font-bold text-slate-900">1. Tulis Info & Menu Toko</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Ketik nama tokomu, jam buka, nomor WhatsApp, alamat, dan daftar harga menu. Mau tambah foto produk juga bisa.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 flex items-center justify-center">
                    <img src="{{ asset('icons/retro/qr-scan.png') }}" class="w-12 h-12 rounded-2xl object-contain drop-shadow-xs" alt="Cetak QR">
                </div>
                <h3 class="text-lg font-bold text-slate-900">2. Download & Cetak Stiker QR</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Sistem otomatis bikinin QR Code resolusi tinggi siap cetak yang pas buat dipajang di akrilik meja atau kasir.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 flex items-center justify-center">
                    <img src="{{ asset('icons/retro/menu.png') }}" class="w-12 h-12 rounded-2xl object-contain drop-shadow-xs" alt="Pelanggan Scan">
                </div>
                <h3 class="text-lg font-bold text-slate-900">3. Pelanggan Tinggal Scan di HP</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Nggak perlu lagi bolak-balik jawab 'Mas, menunya apa aja?' atau 'Buka sampai jam berapa?'. Semua info langsung tampil di HP.
                </p>
            </div>
        </div>
    </section>

    <!-- Featured Demo Stores -->
    <section class="max-w-5xl mx-auto px-4 space-y-6">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Toko & Usaha Terdaftar</h2>
                <p class="text-xs text-slate-500 mt-1">Coba buka halaman profil atau lihat tampilan menu di bawah ini:</p>
            </div>
            <a href="{{ route('stores.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <span>Lihat Semua</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredStores as $store)
                <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                {{ $store->category }}
                            </span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $store->is_open ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700' }}">
                                {{ $store->is_open ? 'Buka' : 'Tutup' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                                @if($store->logo_url)
                                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="font-bold text-xs text-emerald-700">{{ strtoupper(substr($store->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base font-bold text-slate-900 leading-snug truncate">{{ $store->name }}</h3>
                                @if($store->tagline)
                                    <p class="text-xs text-emerald-600 font-medium truncate mt-0.5">{{ $store->tagline }}</p>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $store->description ?? 'Profil informasi toko dan menu digital.' }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                            <span class="inline-flex items-center gap-1.5">
                                <img src="{{ asset('icons/retro/menu.png') }}" class="w-4 h-4 rounded-xs object-contain" alt="Menu">
                                <span>{{ $store->products_count }} Menu</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <img src="{{ asset('icons/retro/telepon.png') }}" class="w-4 h-4 rounded-xs object-contain" alt="Telepon">
                                <span>{{ $store->phone }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-5">
                        <a href="{{ route('stores.show', $store->slug) }}" class="py-2.5 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold text-center transition-all">
                            Buka Menu Toko
                        </a>
                        <a href="{{ route('stores.qr', $store->slug) }}" class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold text-center transition-all">
                            Cetak QR Meja
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-slate-200 text-slate-500">
                    Belum ada toko yang terdaftar. Ayo jadi yang pertama!
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
