<x-layouts.app title="PentaCart IDN - Katalog QRIS & Pesan Antar Asrama Mahasiswa">
    {{-- 1. HERO STAGE: Editorial + 3D QRIS Kampus Hub (1:1 moodboard inspired) --}}
    <section class="relative pt-2 pb-10 sm:pb-14 animate-editorial-in">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6 items-center">
            {{-- Kiri: Copywriting Editorial Padat + Live Search Bar --}}
            <div class="lg:col-span-5 space-y-5 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50/90 border border-blue-200/80 rounded-full shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    Satu Hub QRIS Mahasiswa IDN
                </span>

                <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-slate-900 tracking-tight leading-[1.1]">
                    Satu Portal, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600">Semua QRIS Lapak</span> Kampus.
                </h1>

                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-md mx-auto lg:mx-0">
                    Cari jajanan, nama penjual, atau kategori favoritmu. Scan QRIS langsung di halaman ini, lalu konfirmasi antar asrama via WhatsApp.
                </p>

                {{-- Search Bar Utama --}}
                <form action="{{ route('home') }}#katalog-lapak" method="GET" class="relative max-w-md mx-auto lg:mx-0">
                    <input type="text"
                           id="hero-search-input"
                           name="q"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari lapak, menu, atau nama penjual..."
                           class="w-full pl-4 pr-20 py-3.5 text-sm rounded-2xl bg-white/95 border border-blue-200/80 focus:border-blue-600 focus:ring-4 focus:ring-blue-500/15 outline-none shadow-md shadow-blue-900/5 transition placeholder:text-slate-400">
                    <button type="submit"
                            class="absolute right-1.5 top-1.5 bottom-1.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition cursor-pointer">
                        Cari
                    </button>
                </form>

                {{-- Quick Keyword Pills --}}
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-1.5 text-[11px]">
                    <span class="text-slate-400 font-semibold mr-1">Cepat:</span>
                    @foreach (['Basreng', 'Mie', 'Aqeep', 'Roti Aoka', 'Gorio Rio'] as $pill)
                        <a href="{{ route('home', ['q' => $pill]) }}#katalog-lapak"
                           class="px-2.5 py-1 rounded-full font-semibold border transition {{ strtolower($search ?? '') === strtolower($pill) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white/80 text-slate-600 border-slate-200/80 hover:border-blue-300 hover:text-blue-700' }}">
                            {{ $pill }}
                        </a>
                    @endforeach
                    @if (! empty($search))
                        <a href="{{ route('home') }}#katalog-lapak" class="px-2.5 py-1 rounded-full font-bold text-rose-600 bg-rose-50 border border-rose-200 hover:bg-rose-100">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            {{-- Kanan: Panggung Visual 3D Golden-Hour + Interactive Overlays --}}
            <div class="lg:col-span-7">
                <div id="hero-3d-stage"
                     class="relative mx-auto max-w-[580px] rounded-[2rem] p-1.5 bg-gradient-to-br from-amber-100/70 via-white/90 to-blue-100/80 border border-white/90 shadow-2xl shadow-blue-900/15"
                     style="perspective: 1200px;">

                    <div id="hero-3d-parallax"
                         class="relative w-full aspect-[4/3] rounded-[1.65rem] overflow-hidden shadow-inner transition-transform duration-200 ease-out bg-slate-100"
                         style="transform-style: preserve-3d;">

                        <img src="{{ asset('images/hero-qris-kampus.webp') }}"
                             alt="Ekosistem QRIS Mahasiswa Kampus PentaCart IDN"
                             fetchpriority="high"
                             class="w-full h-full object-cover select-none pointer-events-none">

                        {{-- Animated Laser Scanner Sweep inside Central Smartphone QR Box --}}
                        <div class="pointer-events-none absolute left-[43.2%] top-[36.5%] w-[13.5%] h-[17.5%] overflow-hidden rounded-md z-10"
                             style="transform: skewY(-2deg);">
                            <div class="scanner-beam w-full h-[3px] bg-gradient-to-r from-blue-500/0 via-blue-500 to-blue-500/0 shadow-[0_0_10px_2px_rgba(37,99,235,0.75)]"></div>
                        </div>

                        {{-- 6 Interactive Hotspots over Floating Cards (Desktop/Tablet) --}}
                        <a href="{{ route('home', ['q' => 'Makanan']) }}#katalog-lapak"
                           aria-label="Filter Kantin"
                           title="Cari lapak Kantin & Makanan"
                           class="hidden sm:flex items-end justify-center pb-1 absolute left-[5.5%] top-[12.5%] w-[21.5%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Cari Kantin &rarr;</span>
                        </a>

                        <a href="{{ route('home', ['q' => 'Jasa']) }}#katalog-lapak"
                           aria-label="Filter Copy Center"
                           title="Cari jasa Copy Center & Print"
                           class="hidden sm:flex items-end justify-center pb-1 absolute left-[4.5%] top-[32.5%] w-[23%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Cari Jasa &rarr;</span>
                        </a>

                        <a href="{{ route('home', ['q' => 'Asrama']) }}#katalog-lapak"
                           aria-label="Filter Laundry"
                           title="Cari layanan Asrama & Laundry"
                           class="hidden sm:flex items-end justify-center pb-1 absolute left-[5.5%] top-[54%] w-[21.5%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Area Asrama &rarr;</span>
                        </a>

                        <a href="{{ route('home', ['q' => 'Kopi']) }}#katalog-lapak"
                           aria-label="Filter Perpustakaan & Kopi"
                           title="Cari teman ngopi & belajar"
                           class="hidden sm:flex items-end justify-center pb-1 absolute right-[5.5%] top-[12.5%] w-[24.5%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Cari Kopi &rarr;</span>
                        </a>

                        <a href="{{ route('home', ['q' => 'Dimsum']) }}#katalog-lapak"
                           aria-label="Filter Toko Kampus"
                           title="Cari Toko Kampus & Dimsum"
                           class="hidden sm:flex items-end justify-center pb-1 absolute right-[4.5%] top-[32.5%] w-[25%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Toko Kampus &rarr;</span>
                        </a>

                        <a href="{{ route('home', ['q' => 'Snack']) }}#katalog-lapak"
                           aria-label="Filter Transportasi & Antar"
                           title="Cari jajanan siap antar"
                           class="hidden sm:flex items-end justify-center pb-1 absolute right-[5.5%] top-[54%] w-[24.5%] h-[11.5%] rounded-2xl border border-transparent hover:border-blue-400/70 hover:bg-blue-500/10 hover:shadow-[0_0_0_3px_rgba(37,99,235,0.18)] transition group">
                            <span class="opacity-0 group-hover:opacity-100 transition text-[9px] font-extrabold bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">Snack Antar &rarr;</span>
                        </a>
                    </div>
                </div>
                <p class="hidden sm:flex items-center justify-center gap-1.5 mt-2.5 text-[11px] font-medium text-slate-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Tip: Arahkan kursor atau klik kartu kategori di dalam visual untuk memfilter katalog.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. BARISAN QRIS & DAFTAR LAPAK KAMPUS --}}
    <section id="katalog-lapak" class="pt-4 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 pb-2 border-b border-blue-100/80">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Barisan QRIS &amp; Lapak Mahasiswa
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if (! empty($search))
                        Menampilkan hasil untuk <strong class="text-blue-700">"{{ $search }}"</strong> &bull;
                    @endif
                    <span class="hidden md:inline">Arahkan kursor ke kartu untuk memunculkan QRIS dari belakang card, atau klik langsung untuk zoom &amp; download.</span>
                    <span class="md:hidden">Tap QRIS di kartu untuk memperbesar, download, atau langsung chat penjual.</span>
                </p>
            </div>
            
            <div class="flex items-center gap-2 self-start sm:self-auto flex-wrap">
                {{-- Filter Pill: Semua vs Sedang Buka Saja --}}
                <div class="inline-flex rounded-xl bg-slate-100 p-0.5 border border-slate-200/70 text-xs font-bold">
                    <a href="{{ route('home', array_filter(['q' => $search])) }}#katalog-lapak"
                       class="px-3 py-1.5 rounded-lg transition {{ empty($openOnly) ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        Semua Lapak
                    </a>
                    <a href="{{ route('home', array_filter(['q' => $search, 'open_only' => 1])) }}#katalog-lapak"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition {{ !empty($openOnly) ? 'bg-emerald-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ !empty($openOnly) ? 'bg-white animate-pulse' : 'bg-emerald-500' }}"></span>
                        Sedang Buka
                    </a>
                </div>

                <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200/70 px-3 py-1.5 rounded-xl">
                    {{ $merchants->count() }} Lapak
                </span>
            </div>
        </div>

        @if ($merchants->isEmpty())
            <div class="glass-card rounded-3xl p-10 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 font-black text-xl">
                    ?
                </div>
                <h3 class="text-base font-extrabold text-slate-800">
                    {{ ! empty($search) ? 'Lapak Tidak Ditemukan' : 'Belum Ada Lapak Terdaftar' }}
                </h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-5">
                    @if (! empty($search))
                        Coba kata kunci lain seperti nama makanan, minuman, atau reset pencarian.
                    @else
                        Jadilah mahasiswa pertama yang memajang QRIS jualannya di PentaCart IDN!
                    @endif
                </p>
                @if (! empty($search))
                    <a href="{{ route('home') }}#katalog-lapak" class="inline-flex text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-xs transition">
                        Tampilkan Semua Lapak
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-xs transition">
                        Mulai Buka Lapak
                    </a>
                @endif
            </div>
        @else
            <div class="merchant-bento-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                @foreach ($merchants as $m)

                    @php
                        $op = $m->operationalStatus();
                        $qrisUrl = $m->qris_image ? asset('storage/' . $m->qris_image) : null;
                        $waChatText = rawurlencode("Halo {$m->name}, saya lihat lapaknya di PentaCart IDN. Mau tanya / pesan ya!");
                        $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $m->phone) . '?text=' . $waChatText;
                    @endphp

                    <article id="card-{{ $m->slug }}"
                             class="merchant-bento-card group/card relative rounded-3xl p-5 bg-white/95 border border-slate-200/80 shadow-md shadow-blue-900/5 flex flex-col justify-between overflow-hidden min-h-[380px]">
                        
                        {{-- Ambient Glass Accent --}}
                        <div class="pointer-events-none absolute -right-12 -top-12 w-36 h-36 rounded-full bg-blue-500/5 blur-2xl group-hover/card:bg-blue-500/10 transition-colors"></div>

                        {{-- Card Header: Status + Toggle Mobile Pill + Copy Link --}}
                        <div class="relative z-10 flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $op['open'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $op['open'] ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                {{ $op['label'] }}
                            </span>

                            <div class="flex items-center gap-1.5">
                                {{-- Tombol Toggle QRIS Mobile (Bisa di-tap di HP untuk intip QRIS) --}}
                                @if ($qrisUrl)
                                    <button type="button"
                                            onclick="toggleCardQris('card-{{ $m->slug }}')"
                                            class="md:hidden inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white text-[10px] font-extrabold border border-blue-200/70 transition cursor-pointer">
                                        <span class="toggle-text-label">Lihat QRIS</span>
                                    </button>
                                @endif

                                {{-- Salin Link Lapak --}}
                                <button type="button"
                                        onclick="copyShopLink({{ Js::from(route('buyer.shop', $m->slug)) }}, this)"
                                        title="Salin Link Lapak"
                                        aria-label="Salin Link Lapak {{ $m->name }}"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition border border-transparent hover:border-blue-100 cursor-pointer">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Card Middle: Dynamic Holographic Stage --}}
                        <div class="relative z-10 flex-1 py-3.5 flex flex-col justify-center overflow-hidden">
                            
                            {{-- Panel 1: Info Lapak & Mini Menu (Tampil Default) --}}
                            <div class="shutter-menu-panel space-y-2">
                                <a href="{{ route('buyer.shop', $m->slug) }}" class="block group/title">
                                    <h3 class="font-black text-lg text-slate-900 group-hover/title:text-blue-600 tracking-tight leading-snug transition-colors line-clamp-1">
                                        {{ $m->name }}
                                    </h3>
                                </a>

                                @if ($m->location)
                                    <p class="text-[11px] font-semibold text-blue-700 flex items-center gap-1">
                                        <svg class="size-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate">{{ $m->location }}</span>
                                    </p>
                                @endif

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $m->description ?? 'Lapak resmi mahasiswa kampus IDN.' }}
                                </p>

                                {{-- Daftar Menu Preview --}}
                                @if ($m->products->isNotEmpty())
                                    <div class="pt-2.5 mt-2 border-t border-dashed border-slate-200/80 space-y-1.5">
                                        @foreach ($m->products->take(2) as $prod)
                                            <div class="flex items-center justify-between text-[11px] bg-slate-50/80 px-2.5 py-1 rounded-lg">
                                                <span class="text-slate-700 font-medium truncate pr-2">{{ $prod->name }}</span>
                                                <span class="font-bold text-slate-900 shrink-0">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <p class="hidden md:block text-[10px] font-semibold text-blue-500/80 pt-1 text-center italic">
                                    ✦ Sorot kursor untuk memindai QRIS ✦
                                </p>
                            </div>

                            {{-- Panel 2: Holographic QRIS Shutter (Meluncur Halus dari Bawah saat Hover/Tap) --}}
                            <div class="shutter-qris-panel absolute inset-0 flex flex-col items-center justify-center p-2 rounded-2xl bg-gradient-to-b from-blue-50/90 via-white to-slate-50/95 border border-blue-200/70 shadow-inner">
                                @if ($qrisUrl)
                                    <button type="button"
                                            onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                            class="relative group/qr flex flex-col items-center cursor-pointer p-2 rounded-xl bg-white border border-slate-200/90 shadow-sm hover:border-blue-400 transition">
                                        
                                        {{-- Laser Scanner Shutter Sweep --}}
                                        <div class="pointer-events-none absolute inset-x-2 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent shadow-[0_0_8px_1px_rgba(59,130,246,0.8)] scanner-shutter-beam opacity-0 z-20"></div>

                                        <img src="{{ $qrisUrl }}"
                                             alt="QRIS {{ $m->name }}"
                                             class="w-36 h-36 object-contain rounded-lg bg-white select-none">
                                        
                                        <span class="mt-1.5 text-[10px] font-extrabold text-blue-600 group-hover/qr:underline flex items-center gap-1">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                            Perbesar / Unduh
                                        </span>
                                    </button>
                                @else
                                    <div class="py-6 text-center text-slate-400">
                                        <span class="text-xs font-bold">QRIS Belum Tersedia</span>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- Card Footer: Action Buttons (Selalu Tersedia & Stabil) --}}
                        <div class="relative z-10 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <a href="{{ route('buyer.shop', $m->slug) }}" class="flex-1 py-2 px-3 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200/80 text-xs font-bold transition text-center">
                                Menu &rarr;
                            </a>
                            
                            @if ($qrisUrl)
                                <button type="button"
                                        onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                        class="flex-1 py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition cursor-pointer text-center">
                                    Scan QRIS
                                </button>
                            @else
                                <span class="flex-1 py-2 px-3 rounded-xl bg-slate-100 text-slate-400 text-xs font-bold text-center">
                                    Tanpa QRIS
                                </span>
                            @endif

                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                               class="py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200/80 text-xs font-bold transition text-center">
                                Chat WA
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    {{-- 3. MODAL ZOOM & DOWNLOAD QRIS --}}
    <div id="qris-zoom-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4"
         onclick="if (event.target === this) closeQrisModal()">
        <div class="relative w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl border border-blue-100 text-center animate-editorial-in">
            <button type="button" onclick="closeQrisModal()"
                    aria-label="Tutup modal QRIS"
                    class="absolute right-4 top-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm flex items-center justify-center cursor-pointer">
                &times;
            </button>

            <span id="modal-qris-status" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200 mb-2">
                QRIS Resmi
            </span>
            <h3 id="modal-qris-title" class="text-xl font-black text-slate-900 tracking-tight">Nama Lapak</h3>
            <p id="modal-qris-location" class="text-xs text-slate-500 mt-0.5 mb-4">Lokasi</p>

            <div class="p-4 rounded-2xl bg-slate-50 border border-blue-100 inline-block mb-5">
                <img id="modal-qris-img" src="" alt="QRIS Zoom" class="w-60 h-60 object-contain rounded-xl bg-white mx-auto">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <a id="modal-qris-download" href="#" download="qris-pentacart.svg"
                   class="py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition text-center">
                    Download QRIS
                </a>
                <a id="modal-qris-wa" href="#" target="_blank" rel="noopener noreferrer"
                   class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition text-center">
                    Chat WA Penjual
                </a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const stage = document.getElementById('hero-3d-stage');
            const parallax = document.getElementById('hero-3d-parallax');
            const canHover = window.matchMedia('(hover: hover)').matches;
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (stage && parallax && canHover && !reduced) {
                stage.addEventListener('pointermove', (e) => {
                    const rect = stage.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width - 0.5) * 6;
                    const y = ((e.clientY - rect.top) / rect.height - 0.5) * -5;
                    parallax.style.transform = `rotateY(${x.toFixed(2)}deg) rotateX(${y.toFixed(2)}deg)`;
                });
                stage.addEventListener('pointerleave', () => {
                    parallax.style.transform = 'rotateY(0deg) rotateX(0deg)';
                });
            }
        })();

        function openQrisModal(name, imgUrl, waUrl, location, status) {
            const modal = document.getElementById('qris-zoom-modal');
            document.getElementById('modal-qris-title').textContent = name;
            document.getElementById('modal-qris-location').textContent = location;
            document.getElementById('modal-qris-status').textContent = status;
            document.getElementById('modal-qris-img').src = imgUrl;
            document.getElementById('modal-qris-download').href = imgUrl;
            document.getElementById('modal-qris-download').setAttribute('download', 'qris-' + name.toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.svg');
            document.getElementById('modal-qris-wa').href = waUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeQrisModal() {
            const modal = document.getElementById('qris-zoom-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Toggle QRIS on mobile cards
        function toggleCardQris(cardId) {
            const card = document.getElementById(cardId);
            if (!card) return;
            const isQrisActive = card.classList.toggle('show-qris-active');
            const label = card.querySelector('.toggle-text-label');
            if (label) {
                label.innerText = isQrisActive ? 'Lihat Menu' : 'Lihat QRIS';
            }
        }

        function copyShopLink(url, btn) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url);
            } else {
                const input = document.createElement('input');
                input.value = url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
            }

            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="text-[9px] font-black text-emerald-600 px-1">Disalin!</span>';
            btn.classList.add('bg-emerald-50', 'text-emerald-600');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-emerald-50', 'text-emerald-600');
            }, 1800);
        }

        document.addEventListener('keydown', (e) => {
            closeQrisModal();
        });

        // Dynamic typing placeholder based on actual registered merchants & students
        (function () {
            const searchInput = document.getElementById('hero-search-input');
            if (!searchInput) return;

            const suggestions = [
                'Cari "Hammam" (Gorio Rio)...',
                'Cari "Arya" (Mie & Jasa Masak)...',
                'Cari "Aqeep" (Moring Pedas)...',
                'Cari "Rafi" (Basreng & Usus)...',
                'Cari "Nabil" (Keripik Pisang)...',
                'Cari "Fauzan" (Corndog Sakan)...',
                'Cari "Dzulfathan" (Roti Aoka)...',
                'Cari "Azhar" (Ceroxand Basreng)...',
                'Cari "Azhim" (Ubilum)...',
                'Cari "Ghulam" (Junk Food)...'
            ];

            let sIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            let isFocused = false;

            searchInput.addEventListener('focus', () => { isFocused = true; });
            searchInput.addEventListener('blur', () => { isFocused = false; });

            function typeStep() {
                if (isFocused || searchInput.value.length > 0) {
                    setTimeout(typeStep, 1000);
                    return;
                }

                const currentText = suggestions[sIndex];
                if (isDeleting) {
                    charIndex--;
                    searchInput.setAttribute('placeholder', currentText.substring(0, charIndex));
                    if (charIndex === 0) {
                        isDeleting = false;
                        sIndex = (sIndex + 1) % suggestions.length;
                        setTimeout(typeStep, 450);
                        return;
                    }
                    setTimeout(typeStep, 40);
                } else {
                    charIndex++;
                    searchInput.setAttribute('placeholder', currentText.substring(0, charIndex));
                    if (charIndex === currentText.length) {
                        isDeleting = true;
                        setTimeout(typeStep, 2200); // pause saat teks selesai
                        return;
                    }
                    setTimeout(typeStep, 70);
                }
            }

            setTimeout(typeStep, 1200);
        })();
    </script>
</x-layouts.app>
