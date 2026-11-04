@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Eksplor Toko & Usaha Lokal</h1>
            <p class="text-xs text-slate-500 mt-1">Jelajahi halaman profil digital dan daftar harga menu dari para pemilik usaha.</p>
        </div>

        <a href="{{ route('stores.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Buat Profil Toko</span>
        </a>
    </div>

    <!-- Store Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($stores as $store)
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
                            <h3 class="text-base font-bold text-slate-900 truncate leading-snug">{{ $store->name }}</h3>
                            @if($store->tagline)
                                <p class="text-xs text-emerald-600 font-medium truncate mt-0.5">{{ $store->tagline }}</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $store->description ?? 'Tidak ada deskripsi.' }}</p>

                    <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-500 font-medium">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                <span>Total Menu:</span>
                            </span>
                            <strong class="text-slate-800">{{ $store->products_count }} item</strong>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>WhatsApp:</span>
                            </span>
                            <span class="text-slate-700">{{ $store->phone }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mt-5">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('stores.show', $store->slug) }}" class="py-2.5 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold text-center transition-all">
                            Buka Menu Toko
                        </a>
                        <a href="{{ route('stores.qr', $store->slug) }}" class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold text-center transition-all">
                            Cetak QR Meja
                        </a>
                    </div>
                    @if(Auth::check() && ($store->user_id === Auth::id() || $store->user_id === null))
                        <a href="{{ route('stores.edit', $store->slug) }}" class="flex items-center justify-center gap-1.5 w-full py-2 px-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-[11px] font-semibold text-center transition-all">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Kelola Info & Menu</span>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 text-slate-500 space-y-3">
                <p class="text-sm font-medium">Belum ada toko yang terdaftar.</p>
                <a href="{{ route('stores.create') }}" class="inline-block px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold">
                    Daftarkan Toko Pertama Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $stores->links() }}
    </div>
</div>
@endsection
