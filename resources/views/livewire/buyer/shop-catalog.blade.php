<div class="py-2 sm:py-4 space-y-6">
    {{-- Navigasi Kembali & Banner Lapak --}}
    <div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-3">
            <span>&larr;</span>
            <span>Kembali ke Semua Lapak</span>
        </a>

        <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-md shadow-blue-900/5">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $merchant->is_open ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                        {{ $merchant->is_open ? '🟢 Buka' : '⚪ Tutup' }}
                    </span>
                    @if ($merchant->location)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold text-slate-600 bg-slate-100">
                            📍 {{ $merchant->location }}
                        </span>
                    @endif
                    <span class="text-xs text-slate-400 font-mono">
                        /{{ $merchant->slug }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $merchant->name }}
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
                    {{ $merchant->description ?? 'Lapak jajanan dan kebutuhan santri/mahasiswa asrama kampus IDN.' }}
                </p>
            </div>

            {{-- Tombol Aksi Header: Buka QRIS & Tombol Keranjang HP --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" wire:click="openQrisModal"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-600/25 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    <span>Lihat QRIS Lapak</span>
                </button>

                @if ($totalQuantity > 0)
                    <button type="button" wire:click="openMobileCart"
                        class="lg:hidden w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/25 transition active:scale-95 cursor-pointer">
                        <span>🛒 Keranjang ({{ $totalQuantity }})</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Banner Notifikasi Toko Tutup --}}
    @if (!$merchant->is_open)
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-800 text-xs sm:text-sm font-semibold flex items-center gap-2 shadow-xs">
            <span class="text-base">⚠️</span>
            <span>Lapak ini sedang tutup sementara. Anda tetap dapat melihat menu jajanan, namun pemesanan sedang dinonaktifkan.</span>
        </div>
    @endif

    {{-- Konten Utama: 2 Kolom (Kiri: Katalog & Pencarian, Kanan: Keranjang & Form Pengiriman Asrama Desktop) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        {{-- KOLOM KIRI: Pencarian & Daftar Jajanan (7 Kolom) --}}
        <div class="lg:col-span-7 space-y-4">
            
            {{-- Kotak Pencarian Livewire (wire:model.live) --}}
            <div class="glass-card rounded-2xl p-4 shadow-xs">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari jajanan (misal: pisang coklat, es teh, risol, mie...)"
                        class="w-full pl-10 pr-10 py-3 text-xs sm:text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition placeholder:text-slate-400">

                    @if ($search !== '')
                        <button type="button" wire:click="$set('search', '')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <span class="text-sm font-bold">&times;</span>
                        </button>
                    @endif
                </div>

                <div class="mt-2.5 flex items-center justify-between text-[11px] text-slate-500 px-1">
                    <span>
                        @if ($search !== '')
                            Hasil pencarian untuk "<strong class="text-slate-700">{{ $search }}</strong>"
                        @else
                            Menampilkan semua menu jajanan
                        @endif
                    </span>
                    <span class="font-semibold text-blue-600">
                        {{ $products->count() }} Menu
                    </span>
                </div>
            </div>

            {{-- Grid Kartu Jajanan --}}
            @if ($products->isEmpty())
                <div class="glass-card rounded-3xl p-8 sm:p-12 text-center shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 text-2xl font-bold">
                        🍱
                    </div>
                    @if ($search !== '')
                        <h3 class="text-base font-bold text-slate-800">Menu Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                            Tidak ada menu jajanan yang cocok dengan pencarian "<strong>{{ $search }}</strong>".
                        </p>
                        <button type="button" wire:click="$set('search', '')" class="text-xs font-bold text-blue-600 hover:underline">
                            Tampilkan Semua Menu
                        </button>
                    @else
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Menu Jajanan</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                            Lapak ini belum mengunggah daftar produk/menu jajanan. Silakan periksa kembali nanti.
                        </p>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($products as $product)
                        @php
                            // Penentuan tema ilustrasi placeholder berdasarkan kata kunci menu
                            $nameLower = strtolower($product->name . ' ' . ($product->description ?? ''));
                            
                            if (str_contains($nameLower, 'mie') || str_contains($nameLower, 'ramen') || str_contains($nameLower, 'bakso') || str_contains($nameLower, 'soto')) {
                                $theme = [
                                    'gradient' => 'from-amber-50 via-orange-50 to-amber-100/70',
                                    'border' => 'border-amber-200/80',
                                    'accent' => 'text-amber-800 bg-amber-100/80 border-amber-300/60',
                                    'badge' => 'Mie & Kuah',
                                    'icon' => '🍜',
                                ];
                            } elseif (str_contains($nameLower, 'kopi') || str_contains($nameLower, 'coffee') || str_contains($nameLower, 'latte') || str_contains($nameLower, 'cappuccino') || str_contains($nameLower, 'espresso')) {
                                $theme = [
                                    'gradient' => 'from-stone-50 via-amber-50 to-stone-100/70',
                                    'border' => 'border-stone-200/80',
                                    'accent' => 'text-stone-800 bg-amber-100/70 border-stone-300/60',
                                    'badge' => 'Kopi & Seduh',
                                    'icon' => '☕',
                                ];
                            } elseif (str_contains($nameLower, 'es ') || str_contains($nameLower, 'teh') || str_contains($nameLower, 'minuman') || str_contains($nameLower, 'jus') || str_contains($nameLower, 'juice') || str_contains($nameLower, 'matcha') || str_contains($nameLower, 'gorio') || str_contains($nameLower, 'boba')) {
                                $theme = [
                                    'gradient' => 'from-cyan-50 via-sky-50 to-blue-100/70',
                                    'border' => 'border-cyan-200/80',
                                    'accent' => 'text-cyan-800 bg-cyan-100/80 border-cyan-300/60',
                                    'badge' => 'Minuman Segar',
                                    'icon' => '🧋',
                                ];
                            } elseif (str_contains($nameLower, 'dimsum') || str_contains($nameLower, 'gyoza') || str_contains($nameLower, 'siomay') || str_contains($nameLower, 'pangsit')) {
                                $theme = [
                                    'gradient' => 'from-rose-50 via-red-50 to-orange-100/70',
                                    'border' => 'border-rose-200/80',
                                    'accent' => 'text-rose-800 bg-rose-100/80 border-rose-300/60',
                                    'badge' => 'Dimsum & Kukus',
                                    'icon' => '🥟',
                                ];
                            } elseif (str_contains($nameLower, 'risol') || str_contains($nameLower, 'gorengan') || str_contains($nameLower, 'cireng') || str_contains($nameLower, 'tahu') || str_contains($nameLower, 'snack') || str_contains($nameLower, 'junk') || str_contains($nameLower, 'kentang') || str_contains($nameLower, 'pisang')) {
                                $theme = [
                                    'gradient' => 'from-yellow-50 via-amber-50 to-yellow-100/70',
                                    'border' => 'border-yellow-200/80',
                                    'accent' => 'text-yellow-900 bg-yellow-100/80 border-yellow-300/60',
                                    'badge' => 'Snack & Gorengan',
                                    'icon' => '🍟',
                                ];
                            } elseif (str_contains($nameLower, 'nasi') || str_contains($nameLower, 'ayam') || str_contains($nameLower, 'bebek') || str_contains($nameLower, 'burger') || str_contains($nameLower, 'rice')) {
                                $theme = [
                                    'gradient' => 'from-emerald-50 via-teal-50 to-emerald-100/70',
                                    'border' => 'border-emerald-200/80',
                                    'accent' => 'text-emerald-900 bg-emerald-100/80 border-emerald-300/60',
                                    'badge' => 'Makanan Utama',
                                    'icon' => '🍱',
                                ];
                            } else {
                                $theme = [
                                    'gradient' => 'from-blue-50 via-indigo-50 to-purple-100/60',
                                    'border' => 'border-indigo-200/80',
                                    'accent' => 'text-indigo-900 bg-indigo-100/80 border-indigo-300/60',
                                    'badge' => 'Menu Asrama',
                                    'icon' => '🍲',
                                ];
                            }

                            // Normalisasi URL foto menu
                            $hasValidImage = !empty($product->image);
                            $productImageUrl = null;
                            if ($hasValidImage) {
                                if (str_starts_with($product->image, 'http://') || str_starts_with($product->image, 'https://')) {
                                    $productImageUrl = $product->image;
                                } else {
                                    $productImageUrl = asset('storage/' . $product->image);
                                }
                            }
                        @endphp

                        <div class="glass-card rounded-2xl p-4 shadow-xs hover:shadow-md transition flex flex-col justify-between border border-slate-200/80 group">
                            <div>
                                {{-- Area Foto Jajanan / Placeholder Ilustrasi Rapi --}}
                                <div class="relative w-full h-40 rounded-xl overflow-hidden mb-3 border border-slate-200/60 bg-slate-50">
                                    @if ($hasValidImage)
                                        {{-- Foto Asli dari Penjual --}}
                                        <img src="{{ $productImageUrl }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                                        
                                        {{-- Fallback jika foto gagal termuat --}}
                                        <div class="hidden w-full h-full flex flex-col items-center justify-center p-3 text-center bg-gradient-to-br {{ $theme['gradient'] }}">
                                            <span class="text-4xl filter drop-shadow-sm group-hover:scale-110 transition-transform duration-200">
                                                {{ $theme['icon'] }}
                                            </span>
                                            <span class="mt-2 text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-full border {{ $theme['accent'] }}">
                                                {{ $theme['badge'] }}
                                            </span>
                                        </div>
                                    @else
                                        {{-- Placeholder Ilustrasi Makanan yang Rapi --}}
                                        <div class="w-full h-full flex flex-col items-center justify-center p-3 text-center relative overflow-hidden bg-gradient-to-br {{ $theme['gradient'] }}">
                                            {{-- Elemen Dekorasi Latar Halus --}}
                                            <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-white/40 blur-sm pointer-events-none"></div>
                                            <div class="absolute -left-4 -top-4 w-16 h-16 rounded-full bg-white/30 blur-xs pointer-events-none"></div>
                                            
                                            {{-- Ikon Ilustrasi Makanan --}}
                                            <span class="text-4xl filter drop-shadow-sm group-hover:scale-110 transition-transform duration-200 z-10">
                                                {{ $theme['icon'] }}
                                            </span>
                                            
                                            {{-- Badge Kategori Menu --}}
                                            <span class="mt-2 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full border {{ $theme['accent'] }} shadow-2xs z-10">
                                                {{ $theme['badge'] }}
                                            </span>
                                            
                                            <span class="text-[9px] font-bold text-slate-400 mt-1 tracking-tight z-10">
                                                PentaCart Kitchen
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Badge Status Ketersediaan --}}
                                    <div class="absolute top-2 right-2 z-20">
                                        @if ($product->is_available)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/90 text-white shadow-xs backdrop-blur-xs">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-700/85 text-white shadow-xs backdrop-blur-xs">
                                                Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Informasi Menu --}}
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base leading-snug group-hover:text-blue-600 transition">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $product->description ?? 'Jajanan lezat siap antar ke kamar asrama.' }}
                                </p>
                            </div>

                            {{-- Harga & Tombol Tambah / Counter --}}
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Harga</span>
                                    <span class="text-sm sm:text-base font-black text-slate-900 tracking-tight">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div>
                                    @if (!$merchant->is_open)
                                        <button disabled
                                            class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                                            Toko Tutup
                                        </button>
                                    @elseif (!$product->is_available)
                                        <button disabled
                                            class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                                            Habis
                                        </button>
                                    @elseif (isset($cart[$product->id]) && $cart[$product->id] > 0)
                                        {{-- Quantity Counter [-] qty [+] --}}
                                        <div class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-200 rounded-xl p-1 shadow-xs">
                                            <button type="button" wire:click="decreaseCart({{ $product->id }})"
                                                class="w-6 h-6 rounded-lg bg-white hover:bg-blue-100 text-blue-700 font-black text-xs flex items-center justify-center transition shadow-xs cursor-pointer">
                                                -
                                            </button>
                                            <span class="text-xs font-black text-blue-800 px-1 min-w-[18px] text-center">
                                                {{ $cart[$product->id] }}
                                            </span>
                                            <button type="button" wire:click="addToCart({{ $product->id }})"
                                                class="w-6 h-6 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-black text-xs flex items-center justify-center transition shadow-xs cursor-pointer">
                                                +
                                            </button>
                                        </div>
                                    @else
                                        {{-- Tombol Tambah ke Pesanan --}}
                                        <button type="button" wire:click="addToCart({{ $product->id }})"
                                            class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white border border-blue-200/80 px-3.5 py-1.5 rounded-xl transition-all active:scale-95 cursor-pointer shadow-xs">
                                            <span>+ Tambah</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- KOLOM KANAN: Keranjang & Form Pengiriman Asrama (Desktop Sidebar) --}}
        <div class="hidden lg:block lg:col-span-5 space-y-4 lg:sticky lg:top-20">
            
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-blue-900/5 space-y-5">
                
                {{-- Header Keranjang --}}
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🛒</span>
                        <h2 class="text-base font-extrabold text-slate-900 tracking-tight">Pesanan Anda</h2>
                    </div>

                    @if (!empty($cart))
                        <button type="button" wire:click="clearCart"
                            class="text-[11px] font-bold text-rose-500 hover:text-rose-700 hover:underline cursor-pointer">
                            Kosongkan
                        </button>
                    @endif
                </div>

                {{-- Alert Error Global Keranjang --}}
                @error('cart')
                    <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                        {{ $message }}
                    </div>
                @enderror

                {{-- List Item Pesanan --}}
                @if (empty($cart) || $cartItems->isEmpty())
                    <div class="py-6 text-center text-slate-400 space-y-1">
                        <div class="text-2xl mb-1">🧺</div>
                        <p class="text-xs font-bold text-slate-700">Keranjang Masih Kosong</p>
                        <p class="text-[11px] text-slate-400">Pilih menu jajanan di sebelah kiri untuk mulai memesan.</p>
                    </div>
                @else
                    <div class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center justify-between gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-slate-800 truncate">{{ $item['product']->name }}</h4>
                                    <span class="text-[11px] text-slate-500">
                                        {{ $item['qty'] }} &times; Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <span class="font-black text-slate-900 block">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </span>
                                    <button type="button" wire:click="removeFromCart({{ $item['product']->id }})"
                                        class="text-[10px] text-rose-500 hover:underline">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Ringkasan Total Tagihan --}}
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/70 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700 block">Total Pembayaran</span>
                            <span class="text-[11px] text-slate-500">{{ $totalQuantity }} Jajanan</span>
                        </div>
                        <span class="text-lg sm:text-xl font-black text-blue-700">
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </span>
                    </div>
                @endif

                {{-- Form Pengiriman Asrama --}}
                <div class="pt-3 border-t border-slate-100 space-y-3.5">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                        <span>🏢</span>
                        <span>Data Pengiriman Asrama</span>
                    </h3>

                    {{-- Nama Pembeli --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nama Pemesan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                            wire:model="buyer_name"
                            placeholder="Contoh: Apip / Budi"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        @error('buyer_name')
                            <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nomor WhatsApp Pembeli --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nomor WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                            wire:model="buyer_phone"
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        @error('buyer_phone')
                            <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Gedung & Nomor Kamar Asrama --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Gedung & Nomor Kamar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                            wire:model="dorm_location"
                            placeholder="Contoh: Gedung Umar Lt. 2, Kamar 204"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        @error('dorm_location')
                            <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Catatan Tambahan (Opsional) --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Catatan Pesanan <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea wire:model="notes" rows="2"
                            placeholder="Contoh: Jangan terlalu pedas, kuah dipisah ya kak..."
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
                        @error('notes')
                            <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Petunjuk QRIS --}}
                    <div class="p-3 rounded-xl bg-blue-50/70 border border-blue-200/60 text-[11px] text-blue-800 space-y-1">
                        <div class="font-bold flex items-center justify-between">
                            <span>💳 Bayar Pakai QRIS Lapak</span>
                            <button type="button" wire:click="openQrisModal" class="underline hover:text-blue-900 cursor-pointer">
                                Buka QRIS &rarr;
                            </button>
                        </div>
                        <p class="text-blue-700/80 leading-relaxed">
                            Scan QRIS toko sebelum atau sesudah klik pesan via WA. Kirimkan screenshot bukti transfer ke WhatsApp penjual.
                        </p>
                    </div>

                    {{-- Tombol Pesan via WA Desktop --}}
                    <div class="pt-2">
                        <button type="button"
                            wire:click="orderViaWhatsApp"
                            wire:loading.attr="disabled"
                            @disabled(!$merchant->is_open || empty($cart))
                            class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-extrabold text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-emerald-600">
                            
                            {{-- State Loading --}}
                            <span wire:loading wire:target="orderViaWhatsApp" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>Menyiapkan Pesanan WA...</span>
                            </span>

                            {{-- State Normal --}}
                            <span wire:loading.remove wire:target="orderViaWhatsApp" class="flex items-center gap-2">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Pesan via WA</span>
                            </span>
                        </button>

                        <p class="text-[10px] text-slate-400 text-center mt-2">
                            Otomatis menyusun format pesanan dan membuka WhatsApp penjual.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- FLOATING STICKY BAR DI LAYAR HP (Mobile Quick Checkout Bar) --}}
    @if ($totalQuantity > 0 && !$showMobileCartModal && !$orderSuccess)
        <div class="lg:hidden fixed bottom-4 inset-x-4 z-40 animate-in slide-in-from-bottom duration-200">
            <button type="button" wire:click="openMobileCart"
                class="w-full flex items-center justify-between p-3.5 px-5 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-900/30 active:scale-98 transition-all cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-white/25 flex items-center justify-center text-xs font-black">
                        {{ $totalQuantity }}
                    </span>
                    <span>Lihat Pesanan & Checkout</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="font-black text-base">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    <span>&rarr;</span>
                </div>
            </button>
        </div>
    @endif

    {{-- MODAL CHECKOUT WHATSAPP DI LAYAR HP (Mobile Friendly Bottom Sheet/Modal - Tidak Kepotong) --}}
    @if ($showMobileCartModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm p-0 sm:p-4 transition-opacity">
            <div class="bg-white w-full max-w-lg rounded-t-3xl sm:rounded-3xl shadow-2xl border border-slate-200 max-h-[90dvh] sm:max-h-[85vh] flex flex-col overflow-hidden animate-in slide-in-from-bottom duration-200">
                
                {{-- Header Modal (Sticky Top) --}}
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-white z-10 shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🛒</span>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base leading-tight">Checkout Pesanan Asrama</h3>
                            <p class="text-[11px] text-slate-500">{{ $totalQuantity }} Jajanan &bull; Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <button type="button" wire:click="closeMobileCart"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-sm font-bold transition cursor-pointer">
                        &times;
                    </button>
                </div>

                {{-- Body Modal (Scrollable - Fit untuk segala layar HP) --}}
                <div class="overflow-y-auto flex-1 p-4 sm:p-6 space-y-4 overscroll-contain">
                    
                    {{-- Alert Error Keranjang --}}
                    @error('cart')
                        <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Ringkasan Item Pesanan --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Item yang Dipesan</span>
                            <button type="button" wire:click="clearCart" class="text-[11px] font-bold text-rose-500 hover:underline">
                                Kosongkan
                            </button>
                        </div>

                        <div class="space-y-2 max-h-44 overflow-y-auto pr-1">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center justify-between gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-slate-800 truncate">{{ $item['product']->name }}</h4>
                                        <span class="text-[11px] text-slate-500">
                                            {{ $item['qty'] }} &times; Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-slate-900">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </span>
                                        <button type="button" wire:click="removeFromCart({{ $item['product']->id }})"
                                            class="text-[10px] text-rose-500 font-bold hover:underline px-1">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Form Data Pengiriman Asrama --}}
                    <div class="pt-3 border-t border-slate-100 space-y-3">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                            <span>🏢</span>
                            <span>Data Pengiriman Asrama</span>
                        </h4>

                        {{-- Nama Pembeli --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Nama Pemesan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                wire:model="buyer_name"
                                placeholder="Contoh: Apip / Budi"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            @error('buyer_name')
                                <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Nomor WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                wire:model="buyer_phone"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            @error('buyer_phone')
                                <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Gedung & Nomor Kamar --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Gedung & Nomor Kamar <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                wire:model="dorm_location"
                                placeholder="Contoh: Gedung Umar Lt. 2, Kamar 204"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            @error('dorm_location')
                                <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Catatan Pesanan --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Catatan Pesanan <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <textarea wire:model="notes" rows="2"
                                placeholder="Contoh: Jangan terlalu pedas, kuah dipisah ya kak..."
                                class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
                            @error('notes')
                                <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Petunjuk QRIS --}}
                        <div class="p-3 rounded-xl bg-blue-50 border border-blue-200/70 text-[11px] text-blue-900 space-y-1">
                            <div class="font-bold flex items-center justify-between">
                                <span>💳 Pembayaran via QRIS Lapak</span>
                                <button type="button" wire:click="openQrisModal" class="underline hover:text-blue-950 cursor-pointer">
                                    Buka QRIS &rarr;
                                </button>
                            </div>
                            <p class="text-blue-800/80">
                                Bukti transfer QRIS dikirimkan bersamaan ke chat WhatsApp setelah menekan tombol pesan.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Footer Modal (Sticky Bottom - Menjamin Tombol Pesan Selalu Terlihat di Layar HP) --}}
                <div class="p-4 bg-white border-t border-slate-100 shrink-0 space-y-2">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-slate-500 font-semibold">Total Tagihan ({{ $totalQuantity }} item):</span>
                        <span class="text-base font-black text-slate-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <button type="button"
                        wire:click="orderViaWhatsApp"
                        wire:loading.attr="disabled"
                        @disabled(!$merchant->is_open || empty($cart))
                        class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-extrabold text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        
                        <span wire:loading wire:target="orderViaWhatsApp" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span>Menyiapkan WhatsApp...</span>
                        </span>

                        <span wire:loading.remove wire:target="orderViaWhatsApp" class="flex items-center gap-2">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Pesan via WA</span>
                        </span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- MODAL KONFIRMASI CHECKOUT WHATSAPP (Muncul Setelah Pesanan Dibuat - Rapi di HP) --}}
    @if ($orderSuccess && $waUrl)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-emerald-200 max-h-[90dvh] flex flex-col overflow-hidden animate-in zoom-in-95 duration-200">
                
                {{-- Header Modal Sukses --}}
                <div class="p-5 pb-3 text-center border-b border-slate-100 bg-emerald-50/60 shrink-0">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-xl font-bold shadow-xs mb-2">
                        ✓
                    </div>
                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 bg-emerald-100/80 rounded-full mb-1">
                        Pesanan Berhasil Dicatat (#{{ $latestOrderId }})
                    </span>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Siap Dikirim ke WhatsApp!</h3>
                </div>

                {{-- Konten Modal Sukses (Scrollable agar tidak kepotong di HP pendek) --}}
                <div class="overflow-y-auto flex-1 p-5 space-y-3.5 text-xs text-slate-600">
                    <p class="text-center text-slate-600 leading-relaxed">
                        Data pesanan antar asrama sudah tersimpan. Klik tombol di bawah untuk langsung membuka WhatsApp penjual dengan format pesanan yang rapi:
                    </p>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="flex justify-between items-center text-slate-700">
                            <span class="font-bold">Lapak:</span>
                            <span class="font-bold text-slate-900">{{ $merchant->name }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-700">
                            <span class="font-bold">Pemesan:</span>
                            <span>{{ $buyer_name }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-700">
                            <span class="font-bold">Antar ke:</span>
                            <span class="truncate max-w-[190px]">{{ $dorm_location }}</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200/80 text-[11px] text-amber-800 space-y-1">
                        <strong class="block text-amber-900">📌 Jangan Lupa Bukti QRIS:</strong>
                        <p>Setelah chat WA terbuka, jangan lupa kirimkan screenshot bukti transfer QRIS toko ya!</p>
                    </div>
                </div>

                {{-- Tombol Aksi Modal Sukses (Sticky Bottom) --}}
                <div class="p-4 bg-white border-t border-slate-100 shrink-0 space-y-2">
                    <a href="{{ $waUrl }}" target="_blank"
                        class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-extrabold text-sm shadow-md shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Buka WhatsApp Sekarang &rarr;</span>
                    </a>

                    <button type="button" wire:click="resetOrder"
                        class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition cursor-pointer">
                        Pesan Lagi / Selesai
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- MODAL POPUP: LIHAT QRIS TOKO (Responsif Layar HP & Laptop - Tidak Kepotong) --}}
    @if ($showQrisModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity"
             wire:click="closeQrisModal"
             wire:keydown.window="closeQrisModal">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 max-h-[90dvh] flex flex-col overflow-hidden relative animate-in fade-in zoom-in-95 duration-150"
                 wire:click.stop>
                
                {{-- Header Modal QRIS --}}
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full mb-1">
                            QRIS Pembayaran Lapak
                        </span>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">{{ $merchant->name }}</h3>
                    </div>

                    <button type="button" wire:click="closeQrisModal"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center text-sm font-bold transition cursor-pointer">
                        &times;
                    </button>
                </div>

                {{-- Body Modal QRIS (Scrollable agar tidak kepotong di HP kecil) --}}
                <div class="overflow-y-auto flex-1 p-4 sm:p-6 space-y-4 text-center">
                    {{-- Gambar QRIS Toko --}}
                    <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
                        @if ($merchant->qris_image)
                            <img src="{{ asset('storage/' . $merchant->qris_image) }}"
                                alt="QRIS {{ $merchant->name }}"
                                class="w-full max-w-[260px] sm:max-w-[280px] max-h-[300px] object-contain rounded-xl bg-white p-2 shadow-xs border border-slate-200">
                            
                            <a href="{{ asset('storage/' . $merchant->qris_image) }}" download
                                class="mt-2.5 text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                                <span>Unduh Gambar QRIS</span>
                            </a>
                        @else
                            <div class="py-8 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-2 text-xl font-bold">
                                    QR
                                </div>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-700">QRIS Belum Diunggah</h4>
                                <p class="text-[11px] text-slate-400 max-w-xs mx-auto mt-1">
                                    Penjual belum mengunggah QRIS. Pembayaran dapat dilakukan tunai (COD) atau hubungi nomor penjual:
                                </p>
                                <div class="mt-2.5 inline-block px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-mono font-bold text-slate-800">
                                    {{ $merchant->phone }}
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Panduan Pembayaran --}}
                    <div class="text-[11px] text-slate-500 text-left bg-blue-50/70 border border-blue-100 rounded-xl p-3 space-y-1">
                        <strong class="text-slate-800 block">💡 Cara Bayar:</strong>
                        <ol class="list-decimal list-inside space-y-0.5 text-slate-600">
                            <li>Buka aplikasi m-Banking atau E-Wallet (BCA, Mandiri, BRI, BSI, GoPay, OVO, ShopeePay, DANA).</li>
                            <li>Pindai QRIS di atas sesuai nominal pesanan.</li>
                            <li>Screenshot bukti pembayaran & lampirkan di WhatsApp penjual.</li>
                        </ol>
                    </div>
                </div>

                {{-- Footer Modal QRIS --}}
                <div class="p-3.5 sm:p-4 bg-white border-t border-slate-100 shrink-0">
                    <button type="button" wire:click="closeQrisModal"
                        class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        Tutup Modal QRIS
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
