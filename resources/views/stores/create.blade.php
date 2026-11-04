@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        @auth
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-600 flex items-center gap-1 mb-2">
                <span>←</span>
                <span>Kembali ke Dashboard Toko Saya</span>
            </a>
        @else
            <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-600 flex items-center gap-1 mb-2">
                <span>←</span>
                <span>Kembali ke Daftar Toko</span>
            </a>
        @endauth
        <h1 class="text-2xl font-black tracking-tight text-slate-900">Daftarkan Toko Baru</h1>
        <p class="text-xs text-slate-500 mt-1">Lengkapi informasi tokomu untuk membuat halaman profil dan QR Code siap cetak.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8">
        <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Upload Logo Toko -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Logo / Foto Profil Toko <span class="text-slate-400 font-normal lowercase">(opsional, format JPG/PNG maks 2MB)</span>
                </label>
                <div class="flex items-center gap-4">
                    <div id="logo-preview-box" class="w-16 h-16 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="logo" id="logo-input" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Logo akan tampil di kartu cetak standee dan halaman profil ponsel pembeli.</p>
                    </div>
                </div>
            </div>

            <!-- Nama & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Toko / Usaha <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Kopi Titik Temu" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kategori Usaha
                    </label>
                    <select name="category" id="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all bg-white">
                        <option value="Kafe & Kopi" {{ old('category') == 'Kafe & Kopi' ? 'selected' : '' }}>Kafe & Kopi</option>
                        <option value="Makanan & Kuliner" {{ old('category') == 'Makanan & Kuliner' ? 'selected' : '' }}>Makanan & Kuliner</option>
                        <option value="Jasa & Grooming" {{ old('category') == 'Jasa & Grooming' ? 'selected' : '' }}>Jasa & Grooming (Barber, Salon, Cuci)</option>
                        <option value="Fashion & Pakaian" {{ old('category') == 'Fashion & Pakaian' ? 'selected' : '' }}>Fashion & Pakaian</option>
                        <option value="Warung & Kelontong" {{ old('category') == 'Warung & Kelontong' ? 'selected' : '' }}>Warung & Kelontong</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Custom Slug (Optional) -->
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Link Toko <span class="text-slate-400 font-normal lowercase">(opsional, dibuat otomatis jika dikosongkan)</span>
                </label>
                <div class="flex items-center rounded-xl border border-slate-300 px-3 bg-slate-50 focus-within:ring-2 focus-within:ring-emerald-500/20 focus-within:border-emerald-500 focus-within:bg-white transition-all">
                    <span class="text-xs text-slate-400 select-none">.../toko/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="kopi-titik-temu" class="w-full py-2.5 px-1 bg-transparent text-sm focus:outline-none">
                </div>
            </div>

            <!-- Tagline -->
            <div>
                <label for="tagline" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Slogan Singkat
                </label>
                <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" placeholder="Contoh: Racikan Kopi Pilihan & Tempat Singgah Nyaman" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            </div>

            <!-- WhatsApp & Instagram -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp Toko <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                    <span class="text-[10px] text-slate-400 mt-1 block">Nomor WhatsApp aktif untuk pertanyaan dari pembeli.</span>
                </div>

                <div>
                    <label for="instagram" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Akun Instagram
                    </label>
                    <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}" placeholder="@kopitoko" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                </div>
            </div>

            <!-- Jam Operasional Interaktif -->
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-3.5">
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
                        value="{{ old('opening_hours', 'Setiap Hari: 08.00 - 22.00 WIB') }}" 
                        placeholder="Contoh: Setiap Hari: 08.00 - 22.00 WIB" 
                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                    >
                    <p class="text-[11px] text-slate-400">Ketik bebas jika tokomu punya jadwal khusus (misal: "Selasa - Minggu: 10.00 - 21.00 WIB (Senin Tutup)").</p>
                </div>
            </div>

            <!-- Google Maps Link -->
            <div>
                <label for="maps_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Link Google Maps <span class="text-slate-400 font-normal lowercase">(opsional, agar pembeli bisa klik petunjuk arah)</span>
                </label>
                <input type="url" name="maps_url" id="maps_url" value="{{ old('maps_url') }}" placeholder="https://maps.app.goo.gl/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            </div>

            <!-- Alamat Lengkap -->
            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Alamat Lengkap
                </label>
                <textarea name="address" id="address" rows="2" placeholder="Jl. Melati No. 12, RT 01/RW 03, Kelurahan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">{{ old('address') }}</textarea>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat Toko
                </label>
                <textarea name="description" id="description" rows="3" placeholder="Ceritakan keunggulan usahamu atau suasana tempat..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">{{ old('description') }}</textarea>
            </div>

            <!-- Banner Pengumuman & Promo -->
            <div>
                <label for="announcement" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Banner Pengumuman Toko <span class="text-slate-400 font-normal lowercase">(opsional, tampil di baris paling atas)</span>
                </label>
                <input type="text" name="announcement" id="announcement" value="{{ old('announcement') }}" placeholder="Contoh: Promo Spesial: Beli 2 gratis 1 donat! | Buka tiap hari 08.00 - 22.00" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
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
                $currentFacilities = old('facilities', []);
            @endphp
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Fasilitas & Layanan (Pilih yang tersedia di toko)
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($availableFacilities as $fac)
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-white border border-slate-200/80 hover:border-emerald-400 cursor-pointer text-xs select-none transition-all">
                            <input type="checkbox" name="facilities[]" value="{{ $fac }}" {{ in_array($fac, (array)$currentFacilities) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="text-[11px] font-semibold text-slate-700 truncate">{{ $fac }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status Buka -->
            <div class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <input type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', '1') ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                <label for="is_open" class="text-xs font-semibold text-slate-700 select-none cursor-pointer">
                    Toko Sedang Buka (Tampilkan badge hijau "Buka Sekarang" di halaman profil)
                </label>
            </div>

            <div class="pt-2 flex items-center justify-end gap-3">
                <a href="{{ Auth::check() ? route('dashboard') : route('stores.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/30 transition-all cursor-pointer">
                    Simpan & Buat QR Code
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('logo-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const box = document.getElementById('logo-preview-box');
                box.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                box.classList.remove('border-dashed');
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
