<div class="py-2 sm:py-4 space-y-6">
    {{-- Header Banner & Toggle Status --}}
    <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg shadow-blue-900/5">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full">
                    Dashboard Penjual
                </span>
                <span class="text-xs text-slate-400 font-mono">/ {{ $merchant->slug }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $merchant->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Atur QRIS statis dan identitas tokomu agar mahasiswa mudah memesan.</p>
        </div>

        {{-- Toggle Buka / Tutup --}}
        <div class="flex items-center gap-3 bg-slate-50/80 p-2 sm:p-2.5 rounded-2xl border border-slate-200/80">
            <span class="text-xs font-bold {{ $is_open ? 'text-emerald-700' : 'text-slate-400' }}">
                {{ $is_open ? 'Toko Buka' : 'Toko Tutup' }}
            </span>
            <button type="button" wire:click="toggleOpen" 
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $is_open ? 'bg-emerald-500' : 'bg-slate-300' }}">
                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $is_open ? 'translate-x-5' : 'translate-x-0' }}"></span>
            </button>
        </div>
    </div>

    <x-merchant.nav :merchant="$merchant" />

    {{-- Alert Flash Message --}}
    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-xs">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Main Grid Form --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Kiri: Form Detail Lapak (7 cols) --}}
        <div class="lg:col-span-7 glass-card rounded-3xl p-6 sm:p-8 shadow-md shadow-blue-900/5">
            <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span>Informasi Toko</span>
            </h2>

            <form wire:submit="updateProfile" class="space-y-4">
                {{-- Nama Toko --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lapak</label>
                    <input type="text" wire:model="name" 
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                    @error('name') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp Aktif</label>
                    <input type="text" wire:model="phone" placeholder="08xxxxxxxxxx" 
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Format: 08xx atau 62xx (Pesan order otomatis dikirim ke nomor ini).</span>
                    @error('phone') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Lokasi / Kamar Asrama --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Lokasi Stand / Kamar Penjual</label>
                    <input type="text" wire:model="location" placeholder="misal: Asrama Umar Lt. 2 / Stand Kantin Depan" 
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                    @error('location') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Deskripsi Lapak --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat Jualan</label>
                    <textarea wire:model="description" rows="3" placeholder="Sedia aneka snack, gorengan hangat, dan minuman dingin segar..." 
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
                    @error('description') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-bold text-sm shadow-md shadow-blue-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Kanan: Upload & Display QRIS (5 cols) --}}
        <div class="lg:col-span-5 glass-card rounded-3xl p-6 sm:p-8 shadow-md shadow-blue-900/5 flex flex-col">
            <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                Gambar QRIS Toko
            </h2>

            <div class="flex-1 flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/60 text-center">
                @if ($new_qris)
                    {{-- Preview Gambar Baru yang Dipilih --}}
                    <div class="space-y-2">
                        <img src="{{ $new_qris->temporaryUrl() }}" alt="Preview QRIS" class="w-48 h-48 object-contain rounded-xl shadow-sm border border-slate-200 bg-white mx-auto">
                        <span class="inline-block text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">Gambar Baru Siap Disimpan</span>
                    </div>
                @elseif ($merchant->qris_image)
                    {{-- QRIS yang Sudah Ada --}}
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $merchant->qris_image) }}" alt="QRIS {{ $merchant->name }}" class="w-48 h-48 object-contain rounded-xl shadow-sm border border-slate-200 bg-white mx-auto">
                        <span class="inline-block text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">QRIS Aktif Terpasang</span>
                    </div>
                @else
                    {{-- Belum Ada QRIS --}}
                    <div class="py-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 text-2xl font-bold">
                            QR
                        </div>
                        <p class="text-xs font-bold text-slate-700">Belum Ada QRIS</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Unggah screenshot gambar QRIS m-banking atau e-wallet toko Anda.</p>
                    </div>
                @endif

                <div class="mt-4 w-full">
                    <label class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 text-xs font-bold text-slate-700 hover:text-blue-600 shadow-xs cursor-pointer transition">
                        <span>Pilih File QRIS...</span>
                        <input type="file" wire:model="new_qris" accept="image/*" class="hidden">
                    </label>
                    <div wire:loading wire:target="new_qris" class="text-[10px] text-blue-600 font-semibold mt-1.5 block">
                        Memproses file gambar...
                    </div>
                    @error('new_qris') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <p class="text-[10px] text-slate-400 mt-4 text-center">
                Mendukung file JPG, PNG, WEBP hingga 2MB. QRIS akan langsung tampil saat mahasiswa membuka lapak tokomu.
            </p>
        </div>
    </div>
</div>
