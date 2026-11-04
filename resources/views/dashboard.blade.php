@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

    <!-- Dashboard Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 text-white shadow-xl">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-2">
                Merchant Area
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Halo, {{ $user->name }}!</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">Kelola informasi tokomu, perbarui daftar harga menu, dan unduh QR code siap cetak.</p>
        </div>

        <a href="{{ route('stores.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold tracking-wide shadow-lg shadow-emerald-500/30 transition-all shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Buat Profil Toko Baru</span>
        </a>
    </div>

    <!-- My Stores Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span>Toko Saya</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                    {{ $stores->count() }}
                </span>
            </h2>

            <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <span>Eksplor Toko Lain</span>
                <span>→</span>
            </a>
        </div>

        @if($stores->isEmpty())
            <div class="text-center py-16 px-4 bg-white rounded-3xl border border-dashed border-slate-300 space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto border border-emerald-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Kamu belum menambahkan toko</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Mulai buat halaman tokomu sekarang. Pelanggan bisa langsung cek menu dan info usahamu lewat scan QR.</p>
                </div>
                <a href="{{ route('stores.create') }}" class="inline-block px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all">
                    Daftarkan Toko Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($stores as $store)
                    <div class="p-5 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
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
                                    <h3 class="text-base font-bold text-slate-900 truncate">{{ $store->name }}</h3>
                                    @if($store->tagline)
                                        <p class="text-xs text-emerald-600 font-medium truncate">{{ $store->tagline }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-500 font-medium">
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5">
                                        <img src="{{ asset('icons/retro/menu.png') }}" class="w-3.5 h-3.5 rounded-xs object-contain" alt="Menu">
                                        <span>Total Menu:</span>
                                    </span>
                                    <strong class="text-slate-800">{{ $store->products_count }} item</strong>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5">
                                        <img src="{{ asset('icons/retro/whatsapp.png') }}" class="w-3.5 h-3.5 rounded-xs object-contain" alt="WhatsApp">
                                        <span>WhatsApp:</span>
                                    </span>
                                    <span class="text-slate-700">{{ $store->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mt-5">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold text-center transition-all flex items-center justify-center gap-1">
                                    <span>Lihat di HP</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                                <a href="{{ route('stores.qr', $store->slug) }}" class="py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold text-center transition-all">
                                    Cetak QR Meja
                                </a>
                            </div>

                            <a href="{{ route('stores.edit', $store->slug) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold text-center transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Kelola Info & Menu</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
