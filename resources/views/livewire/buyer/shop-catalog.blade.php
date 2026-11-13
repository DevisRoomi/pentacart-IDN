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

            {{-- Tombol Lihat QRIS Toko --}}
            <div class="flex items-center gap-2">
                <button type="button" wire:click="openQrisModal"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-600/25 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    <span>Lihat QRIS Lapak</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Banner Notifikasi Toko Tutup --}}
    @if (!$merchant->is_open)
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-800 text-xs sm:text-sm font-semibold flex items-center gap-2">
            <span class="text-base">⚠️</span>
            <span>Lapak ini sedang tutup sementara. Anda tetap dapat melihat menu jajanan, namun pemesanan sedang dinonaktifkan.</span>
        </div>
    @endif

    {{-- Alert Pesanan Berhasil / Redirect WA --}}
    @if ($orderSuccess && $waUrl)
        <div class="glass-card rounded-3xl p-6 sm:p-8 border-2 border-emerald-400 bg-emerald-50/70 shadow-lg text-center space-y-3">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-2xl font-bold">
                ✓
            </div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Pesanan Berhasil Dicatat! (#{{ $latestOrderId }})</h2>
            <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                Sistem sedang mengalihkan Anda ke WhatsApp penjual untuk konfirmasi pesanan dan kirim bukti bayar QRIS.
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-3">
                <a href="{{ $waUrl }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/30 transition hover:scale-[1.02]">
                    <span>Buka WhatsApp Sekarang &rarr;</span>
                </a>
                <button type="button" wire:click="resetOrder"
                    class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition">
                    Pesan Lagi
                </button>
            </div>
        </div>
    @endif

    {{-- Konten Utama: 2 Kolom (Kiri: Katalog & Pencarian, Kanan: Keranjang & Form Pengiriman Asrama) --}}
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
                        <div class="glass-card rounded-2xl p-4 shadow-xs hover:shadow-md transition flex flex-col justify-between border border-slate-200/80 group">
                            <div>
                                {{-- Foto Jajanan / Fallback --}}
                                <div class="relative w-full h-36 rounded-xl overflow-hidden bg-slate-100 mb-3 border border-slate-200/60">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-gradient-to-tr from-slate-50 to-blue-50/50">
                                            <span class="text-3xl">🥟</span>
                                            <span class="text-[10px] font-semibold text-slate-400 mt-1">PentaCart Menu</span>
                                        </div>
                                    @endif

                                    {{-- Badge Status Stok --}}
                                    <div class="absolute top-2 right-2">
                                        @if ($product->is_available)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/90 text-white shadow-xs backdrop-blur-xs">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-700/80 text-white shadow-xs backdrop-blur-xs">
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

        {{-- KOLOM KANAN: Keranjang & Form Pengiriman Asrama (5 Kolom) --}}
        <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-20">
            
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
                    <div class="space-y-2.5 max-h-60 overflow-y-auto pr-1">
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

                    {{-- Tombol Pesan via WA --}}
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

    {{-- MODAL POPUP: LIHAT QRIS TOKO --}}
    @if ($showQrisModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity"
             wire:click="closeQrisModal"
             wire:keydown.window="closeQrisModal">
            <div class="glass-card bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative animate-in fade-in zoom-in-95 duration-150"
                 wire:click.stop>
                
                {{-- Tombol Tutup Silang --}}
                <button type="button" wire:click="closeQrisModal"
                    class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center text-sm font-bold transition cursor-pointer">
                    &times;
                </button>

                <div class="text-center space-y-4">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full mb-2">
                            QRIS Pembayaran Lapak
                        </span>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ $merchant->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Scan kode QRIS di bawah ini dengan aplikasi m-banking atau e-wallet Anda.</p>
                    </div>

                    {{-- Gambar QRIS Toko --}}
                    <div class="p-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
                        @if ($merchant->qris_image)
                            <img src="{{ asset('storage/' . $merchant->qris_image) }}"
                                alt="QRIS {{ $merchant->name }}"
                                class="w-full max-w-[320px] max-h-[360px] object-contain rounded-xl bg-white p-2 shadow-sm border border-slate-200">
                            
                            <a href="{{ asset('storage/' . $merchant->qris_image) }}" download
                                class="mt-3 text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1">
                                <span>Unduh Gambar QRIS</span>
                            </a>
                        @else
                            <div class="py-10 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-2 text-2xl font-bold">
                                    QR
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">QRIS Belum Diunggah</h4>
                                <p class="text-[11px] text-slate-400 max-w-xs mx-auto mt-1">
                                    Penjual belum mengunggah gambar QRIS. Anda dapat membayar langsung secara tunai (COD) atau transfer via WhatsApp:
                                </p>
                                <div class="mt-3 inline-block px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-mono font-bold text-slate-800">
                                    {{ $merchant->phone }}
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Panduan Pembayaran --}}
                    <div class="text-[11px] text-slate-500 text-left bg-blue-50/60 border border-blue-100 rounded-xl p-3 space-y-1">
                        <strong class="text-slate-800 block">💡 Panduan Pembayaran:</strong>
                        <ol class="list-decimal list-inside space-y-0.5 text-slate-600">
                            <li>Buka aplikasi m-Banking / GoPay / OVO / ShopeePay / Dana.</li>
                            <li>Pindai (Scan) QRIS di atas dan bayar sesuai nominal pesanan.</li>
                            <li>Tangkapan layar (screenshot) bukti pembayaran.</li>
                            <li>Kirim bukti tersebut di WhatsApp bersama pesan pesanan.</li>
                        </ol>
                    </div>

                    {{-- Tombol Tutup --}}
                    <div class="pt-2">
                        <button type="button" wire:click="closeQrisModal"
                            class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                            Tutup Modal QRIS
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
