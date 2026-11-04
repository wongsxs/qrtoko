@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

    <!-- Header bar with breadcrumbs & actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 font-medium">Dashboard Toko Saya</a>
                <span>/</span>
                <a href="{{ route('stores.show', $store->slug) }}" class="hover:text-emerald-600 text-slate-800 font-semibold">{{ $store->name }}</a>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 flex items-center gap-2">
                <span>Kelola Toko: {{ $store->name }}</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full {{ $store->is_open ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $store->is_open ? 'Buka' : 'Tutup' }}
                </span>
            </h1>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('stores.show', $store->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                <span>Buka Menu Toko</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            <a href="{{ route('stores.qr', $store->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak QR Meja</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Layout: Left Column = Info & Products, Right Column = QR Studio -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left 2 Cols: Form Info & Products -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Card: Edit Store Info -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Informasi Profil Toko
                </h2>

                <form action="{{ route('stores.update', $store->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Logo Upload / Preview -->
                    <div class="flex items-center gap-4 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <div id="logo-preview-box" class="w-14 h-14 rounded-2xl bg-white border border-slate-300 flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                            @if($store->logo_url)
                                <img src="{{ $store->logo_url }}" alt="Logo {{ $store->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="font-black text-lg text-emerald-600">{{ strtoupper(substr($store->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Logo / Foto Profil Toko</label>
                            <input type="file" name="logo" id="logo-input" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Toko</label>
                            <input type="text" name="name" value="{{ old('name', $store->name) }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori</label>
                            <input type="text" name="category" value="{{ old('category', $store->category) }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $store->instagram) }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>
                    </div>

                    <!-- Jam Operasional Interaktif -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Jam Operasional</span>
                            </label>
                            <button 
                                type="button" 
                                onclick="toggleManualHours()" 
                                id="toggle-hours-mode-btn"
                                class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 underline cursor-pointer"
                            >
                                Tulis Manual
                            </button>
                        </div>

                        <!-- Mode 1: Quick Interactive Builder -->
                        <div id="hours-builder-container" class="space-y-3">
                            <!-- Preset Hari -->
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-500 mb-1.5">Pilihan Hari:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button type="button" onclick="setDayPreset('Setiap Hari', this)" class="day-preset-btn active px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-900 text-white shadow-xs transition-all">
                                        Setiap Hari
                                    </button>
                                    <button type="button" onclick="setDayPreset('Senin - Sabtu', this)" class="day-preset-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all">
                                        Senin - Sabtu
                                    </button>
                                    <button type="button" onclick="setDayPreset('Senin - Jumat', this)" class="day-preset-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all">
                                        Senin - Jumat
                                    </button>
                                    <button type="button" onclick="setDayPreset('24 Jam', this)" class="day-preset-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all">
                                        Buka 24 Jam
                                    </button>
                                </div>
                            </div>

                            <!-- Time Pickers (Hidden if 24 Jam) -->
                            <div id="time-pickers-row" class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Jam Buka</label>
                                    <input 
                                        type="time" 
                                        id="picker_open_time" 
                                        value="08:00" 
                                        onchange="updateGeneratedHours()" 
                                        class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                    >
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Jam Tutup</label>
                                    <input 
                                        type="time" 
                                        id="picker_close_time" 
                                        value="22:00" 
                                        onchange="updateGeneratedHours()" 
                                        class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                    >
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Zona Waktu</label>
                                    <select 
                                        id="picker_timezone" 
                                        onchange="updateGeneratedHours()" 
                                        class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                    >
                                        <option value="WIB">WIB (Waktu Indonesia Barat)</option>
                                        <option value="WITA">WITA (Indonesia Tengah)</option>
                                        <option value="WIT">WIT (Indonesia Timur)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Live Result Preview -->
                            <div class="p-2.5 rounded-xl bg-white border border-slate-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 shadow-2xs">
                                <span class="text-[11px] text-slate-400 font-medium">Tampilan di profil toko:</span>
                                <span id="hours-live-preview" class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/60 truncate">
                                    Setiap Hari: 08.00 - 22.00 WIB
                                </span>
                            </div>
                        </div>

                        <!-- Mode 2: Manual Text Input (Always holds the submitted value) -->
                        <div id="hours-manual-container" class="hidden space-y-1.5">
                            <input 
                                type="text" 
                                name="opening_hours" 
                                id="opening_hours_input" 
                                value="{{ old('opening_hours', $store->opening_hours ?? 'Setiap Hari: 08.00 - 22.00 WIB') }}" 
                                placeholder="Contoh: Setiap Hari: 08.00 - 22.00 WIB" 
                                class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                            >
                            <p class="text-[11px] text-slate-400">Ketik bebas jika tokomu punya jadwal khusus (misal: "Selasa - Minggu: 10.00 - 21.00 WIB (Senin Tutup)").</p>
                        </div>
                    </div>

                    <!-- Link Google Maps -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Link Google Maps <span class="text-slate-400 font-normal lowercase">(opsional, agar pembeli bisa klik petunjuk arah)</span>
                        </label>
                        <input type="url" name="maps_url" value="{{ old('maps_url', $store->maps_url) }}" placeholder="https://maps.app.goo.gl/..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat</label>
                        <input type="text" name="address" value="{{ old('address', $store->address) }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">{{ old('description', $store->description) }}</textarea>
                    </div>

                    <!-- Banner Pengumuman & Promo -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Banner Pengumuman Toko <span class="text-slate-400 font-normal lowercase">(tampil paling atas di ponsel pembeli)</span>
                        </label>
                        <input type="text" name="announcement" value="{{ old('announcement', $store->announcement) }}" placeholder="Contoh: Promo Spesial: Beli 2 gratis 1 donat! | Buka tiap hari 08.00 - 22.00" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>

                    <!-- Fasilitas & Metode Pembayaran -->
                    @php
                        $availableFacilities = [
                            'Menerima QRIS',
                            'Free WiFi',
                            'Parkir Kendaraan',
                            'Bisa Kirim / Delivery',
                            'Ruangan Ber-AC',
                            'Musholla',
                            'Colokan Listrik',
                            'Area Merokok',
                        ];
                        // Also normalize any old facility strings from DB by stripping emojis for comparison
                        $rawDbFacilities = (array)($store->facilities ?? []);
                        $normalizedDbFacilities = array_map(function($f) {
                            return trim(preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{1F900}-\x{1F9FF}\x{1F018}-\x{1F0F5}\x{1F200}-\x{1F270}\x{2300}-\x{23FF}\x{2B50}\x{200D}]/u', '', $f));
                        }, $rawDbFacilities);
                        $currentFacilities = old('facilities', array_merge($rawDbFacilities, $normalizedDbFacilities));
                    @endphp
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">
                            Fasilitas & Layanan (Pilih yang tersedia)
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            @foreach($availableFacilities as $fac)
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-white border border-slate-200/80 hover:border-emerald-400 cursor-pointer text-xs select-none transition-all">
                                    <input type="checkbox" name="facilities[]" value="{{ $fac }}" {{ in_array($fac, (array)$currentFacilities) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-[11px] font-semibold text-slate-700 truncate">{{ $fac }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="is_open" value="1" {{ old('is_open', $store->is_open) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="text-xs font-semibold text-slate-700">Toko Aktif / Buka</span>
                        </label>

                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card: Product Management -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Daftar Menu & Harga
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola daftar menu yang tampil saat pelanggan memindai QR.</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                        {{ $products->count() }} Item
                    </span>
                </div>

                <!-- Form Add Product -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">+ Tambah Produk / Menu Baru</h3>
                    <form action="{{ route('stores.products.store', $store->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Produk / Menu</label>
                                <input type="text" name="name" required placeholder="Contoh: Es Kopi Susu Aren" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kategori</label>
                                <input type="text" name="category" required placeholder="Contoh: Coffee" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Harga (Rp)</label>
                                <input type="number" name="price" required min="0" placeholder="18000" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:outline-none focus:border-emerald-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Singkat</label>
                                <input type="text" name="description" placeholder="Komposisi atau keunggulan menu..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Foto Menu (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-white file:border-slate-200 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer">
                        </div>

                        <div class="flex justify-end pt-1">
                            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                                + Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Products List -->
                <div class="space-y-2.5">
                    @forelse($products as $product)
                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                                    @if($product->image_url_formatted)
                                        <img src="{{ $product->image_url_formatted }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs font-bold text-slate-900 truncate">{{ $product->name }}</h4>
                                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                                            {{ $product->category }}
                                        </span>
                                    </div>
                                    <p class="text-xs font-bold text-emerald-600 mt-0.5">{{ $product->formatted_price }}</p>
                                    @if($product->description)
                                        <p class="text-[11px] text-slate-400 truncate">{{ $product->description }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <form action="{{ route('stores.products.destroy', [$store->slug, $product->id]) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-all" title="Hapus Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-slate-400">
                            Belum ada menu yang ditambahkan. Gunakan formulir di atas untuk mulai memasukkan menu usahamu.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Live QR Studio -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 text-center space-y-4 sticky top-24">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Studio QR Code Toko
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 inline-block shadow-inner">
                    <div id="qrcode-box" class="flex justify-center"></div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-slate-900">{{ $store->name }}</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Link Halaman Toko:</p>
                    <p class="text-xs font-mono text-emerald-600 font-semibold truncate bg-slate-50 px-2 py-1 rounded-lg mt-1 select-all" id="store-link-text">
                        {{ route('stores.show', $store->slug) }}
                    </p>
                </div>

                <div class="space-y-2 pt-2">
                    <button type="button" onclick="downloadQrCode()" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Download QR Code (PNG)</span>
                    </button>

                    <a href="{{ route('stores.qr', $store->slug) }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Format Cetak QR Meja</span>
                    </a>

                    <button type="button" onclick="copyLink()" class="w-full py-2 px-4 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition-all">
                        Salin Link Toko
                    </button>
                </div>

                <div class="pt-4 border-t border-slate-100 text-left">
                    <form action="{{ route('stores.destroy', $store->slug) }}" method="POST" onsubmit="return confirm('Peringatan: Toko dan semua menunya akan dihapus permanen. Lanjutkan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-semibold">
                            Hapus Toko Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const targetUrl = "{{ route('stores.show', $store->slug) }}";
    const storeSlug = "{{ $store->slug }}";

    // Generate QR Code
    const qrcode = new QRCode(document.getElementById("qrcode-box"), {
        text: targetUrl,
        width: 180,
        height: 180,
        colorDark : "#0f172a",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    function downloadQrCode() {
        const img = document.querySelector("#qrcode-box img");
        if (img && img.src) {
            const link = document.createElement("a");
            link.href = img.src;
            link.download = `QR-${storeSlug}.png`;
            link.click();
        } else {
            const canvas = document.querySelector("#qrcode-box canvas");
            if (canvas) {
                const link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = `QR-${storeSlug}.png`;
                link.click();
            }
        }
    }

    function copyLink() {
        navigator.clipboard.writeText(targetUrl).then(() => {
            alert('Tautan toko berhasil disalin!');
        });
    }

    document.getElementById('logo-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const box = document.getElementById('logo-preview-box');
                box.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Operating Hours interactive builder logic
    let currentDayPreset = 'Setiap Hari';
    let isManualHoursMode = false;

    function setDayPreset(preset, btnElement) {
        currentDayPreset = preset;

        document.querySelectorAll('.day-preset-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-slate-900', 'text-white', 'shadow-xs');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-700');
        });

        if (btnElement) {
            btnElement.classList.add('active', 'bg-slate-900', 'text-white', 'shadow-xs');
            btnElement.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-700');
        }

        const pickers = document.getElementById('time-pickers-row');
        if (preset === '24 Jam') {
            if (pickers) pickers.classList.add('hidden');
        } else {
            if (pickers) pickers.classList.remove('hidden');
        }

        updateGeneratedHours();
    }

    function updateGeneratedHours() {
        if (isManualHoursMode) return;

        const input = document.getElementById('opening_hours_input');
        const preview = document.getElementById('hours-live-preview');
        const openVal = document.getElementById('picker_open_time')?.value || '08:00';
        const closeVal = document.getElementById('picker_close_time')?.value || '22:00';
        const tz = document.getElementById('picker_timezone')?.value || 'WIB';

        const openFmt = openVal.replace(':', '.');
        const closeFmt = closeVal.replace(':', '.');

        let text = '';
        if (currentDayPreset === '24 Jam') {
            text = 'Buka 24 Jam Setiap Hari';
        } else if (currentDayPreset === 'Senin - Sabtu') {
            text = `Senin - Sabtu: ${openFmt} - ${closeFmt} ${tz}`;
        } else if (currentDayPreset === 'Senin - Jumat') {
            text = `Senin - Jumat: ${openFmt} - ${closeFmt} ${tz}`;
        } else {
            text = `Setiap Hari: ${openFmt} - ${closeFmt} ${tz}`;
        }

        if (input) input.value = text;
        if (preview) preview.textContent = text;
    }

    function toggleManualHours() {
        isManualHoursMode = !isManualHoursMode;
        const builder = document.getElementById('hours-builder-container');
        const manual = document.getElementById('hours-manual-container');
        const toggleBtn = document.getElementById('toggle-hours-mode-btn');

        if (isManualHoursMode) {
            builder?.classList.add('hidden');
            manual?.classList.remove('hidden');
            if (toggleBtn) toggleBtn.textContent = 'Gunakan Pemilih Otomatis';
        } else {
            manual?.classList.add('hidden');
            builder?.classList.remove('hidden');
            if (toggleBtn) toggleBtn.textContent = 'Tulis Manual';
            updateGeneratedHours();
        }
    }

    function initOpeningHours() {
        const input = document.getElementById('opening_hours_input');
        const val = input ? input.value.trim() : '';

        if (!val) {
            updateGeneratedHours();
            return;
        }

        if (val.toLowerCase().includes('24 jam')) {
            const btn24 = Array.from(document.querySelectorAll('.day-preset-btn')).find(b => b.textContent.includes('24 Jam'));
            setDayPreset('24 Jam', btn24);
            return;
        }

        const match = val.match(/(\d{1,2})[:.](\d{2})\s*[-–]\s*(\d{1,2})[:.](\d{2})/);
        if (match) {
            const openH = match[1].padStart(2, '0');
            const openM = match[2];
            const closeH = match[3].padStart(2, '0');
            const closeM = match[4];

            const openInput = document.getElementById('picker_open_time');
            const closeInput = document.getElementById('picker_close_time');
            if (openInput) openInput.value = `${openH}:${openM}`;
            if (closeInput) closeInput.value = `${closeH}:${closeM}`;

            const tzSelect = document.getElementById('picker_timezone');
            if (tzSelect) {
                if (val.includes('WITA')) tzSelect.value = 'WITA';
                else if (val.includes('WIT')) tzSelect.value = 'WIT';
                else tzSelect.value = 'WIB';
            }

            let foundPreset = null;
            if (val.toLowerCase().includes('senin - jumat')) {
                foundPreset = 'Senin - Jumat';
            } else if (val.toLowerCase().includes('senin - sabtu')) {
                foundPreset = 'Senin - Sabtu';
            } else if (val.toLowerCase().includes('setiap hari')) {
                foundPreset = 'Setiap Hari';
            }

            if (foundPreset) {
                const btn = Array.from(document.querySelectorAll('.day-preset-btn')).find(b => b.textContent.includes(foundPreset));
                setDayPreset(foundPreset, btn);
            } else {
                toggleManualHours();
            }
        } else {
            toggleManualHours();
        }
    }

    document.addEventListener('DOMContentLoaded', initOpeningHours);
</script>
@endpush
@endsection
