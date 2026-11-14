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
                {{-- Audio FX Toggle Button --}}
                <button type="button"
                        id="audio-toggle-btn"
                        onclick="toggleAudioSynth()"
                        aria-label="Toggle Efek Suara Haptik"
                        title="Klik untuk menyalakan/mematikan efek suara interaktif"
                        class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200/80 bg-white text-slate-600 hover:text-blue-600 hover:border-blue-200 text-xs font-bold shadow-2xs transition cursor-pointer">
                    <span id="audio-icon">🔈</span>
                    <span id="audio-status-text">Audio: Nyala</span>
                </button>

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

                {{-- Desktop Navigation Buttons (Geser Kiri/Kanan) --}}
                <div class="hidden md:inline-flex items-center gap-1.5">
                    <button type="button"
                            onclick="scrollRail('left')"
                            aria-label="Geser ke kiri"
                            class="p-2 rounded-xl bg-white hover:bg-blue-50 text-slate-600 hover:text-blue-700 border border-slate-200/80 shadow-2xs transition cursor-pointer">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button"
                            onclick="scrollRail('right')"
                            aria-label="Geser ke kanan"
                            class="p-2 rounded-xl bg-white hover:bg-blue-50 text-slate-600 hover:text-blue-700 border border-slate-200/80 shadow-2xs transition cursor-pointer">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200/70 px-3 py-1.5 rounded-xl">
                    {{ $merchants->count() }} Lapak
                </span>
            </div>
        </div>

        {{-- Ruler Tick Meter Indicator (|||||||) di Atas Rel Kartu --}}
        <div class="hidden md:flex items-center justify-between gap-4 py-2 px-4 mb-2 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-2xs">
            <div class="flex items-center gap-2 text-[11px] font-black tracking-wide text-slate-700">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>POSISI REL KATALOG</span>
            </div>

            {{-- Strip Batang Meteran Ticks (|||||||) --}}
            <div id="ruler-ticks-container" class="flex-1 flex items-center justify-center gap-2 px-4">
                @for ($i = 0; $i < $merchants->count(); $i++)
                    <button type="button"
                            onclick="jumpToRailIndex({{ $i }})"
                            aria-label="Lompat ke lapak nomor {{ $i + 1 }}"
                            title="Lapak {{ $i + 1 }}"
                            class="ruler-tick-item group/tick flex flex-col items-center py-1 px-1 cursor-pointer">
                        <span class="ruler-bar block w-1.5 h-5 rounded-full transition-all duration-200 {{ $i === 0 ? 'bg-blue-600 h-7 scale-y-110 shadow-sm shadow-blue-500/50' : 'bg-slate-300 group-hover/tick:bg-slate-500' }}"></span>
                    </button>
                @endfor
            </div>

            <div class="flex items-center gap-2">
                <span id="ruler-index-badge" class="px-2.5 py-1 rounded-lg bg-blue-600 text-white text-[11px] font-black tracking-wide shadow-2xs">
                    01 / {{ sprintf('%02d', $merchants->count()) }}
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
            {{-- Horizontal Rail Container (Desktop: Horizontal Scroll + 3D Tilt; Mobile: Grid Rapih) --}}
            <div class="relative group/rail pt-2 sm:pt-4">
                
                {{-- Horizontal Scroller --}}
                <div id="merchant-rail-track"
                     class="merchant-rail-track flex flex-col md:flex-row md:overflow-x-auto md:overflow-y-hidden md:scroll-smooth gap-5 sm:gap-6 pb-4 pt-2 md:snap-x md:snap-mandatory no-scrollbar"
                     style="perspective: 1200px;">
                    
                    @foreach ($merchants as $m)

                        @php
                            $op = $m->operationalStatus();
                            $qrisUrl = $m->qris_image ? asset('storage/' . $m->qris_image) : null;
                            $waChatText = rawurlencode("Halo {$m->name}, saya lihat lapaknya di PentaCart IDN. Mau tanya / pesan ya!");
                            $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $m->phone) . '?text=' . $waChatText;
                        @endphp

                        <article id="card-{{ $m->slug }}"
                                 onmouseenter="playHapticSound('hover')"
                                 class="merchant-bento-card group/card relative rounded-3xl p-4 sm:p-5 bg-white/95 border border-slate-200/80 shadow-md shadow-blue-900/5 flex flex-col justify-between overflow-hidden w-full md:w-[305px] lg:w-[320px] md:shrink-0 md:snap-start md:min-h-[415px] transition-all">
                            
                            {{-- Ambient Glass Accent --}}
                            <div class="pointer-events-none absolute -right-12 -top-12 w-36 h-36 rounded-full bg-blue-500/5 blur-2xl group-hover/card:bg-blue-500/10 transition-colors"></div>

                            {{-- Card Header: Status & Salin Link --}}
                            <div class="relative z-10 flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $op['open'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $op['open'] ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                    {{ $op['label'] }}
                                </span>

                                <div class="flex items-center gap-1">
                                    {{-- Tombol Salin Link Lapak --}}
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
                            <div class="relative z-10 flex-1 py-3 flex flex-col justify-center overflow-hidden">
                                
                                {{-- Panel 1: Info Lapak & Mini Menu --}}
                                <div class="shutter-menu-panel space-y-2">
                                    <a href="{{ route('buyer.shop', $m->slug) }}" class="block group/title">
                                        <h3 class="font-black text-lg text-slate-900 group-hover/title:text-blue-600 tracking-tight leading-snug transition-colors line-clamp-1">
                                            {{ $m->name }}
                                        </h3>
                                    </a>

                                    @if ($m->location)
                                        <p class="text-[11px] font-semibold text-blue-700 flex items-center gap-1">
                                            <svg class="size-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        <div class="pt-2 mt-1 space-y-1.5">
                                            @foreach ($m->products->take(2) as $prod)
                                                <div class="flex items-center justify-between text-[11px] bg-slate-50 hover:bg-slate-100/80 px-2.5 py-1.5 rounded-xl border border-slate-100 transition-colors">
                                                    <span class="text-slate-700 font-semibold truncate pr-2">{{ $prod->name }}</span>
                                                    <span class="font-black text-slate-900 shrink-0">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <p class="hidden md:block text-[10px] font-semibold text-blue-500/80 pt-1 text-center italic">
                                        ✦ Sorot kursor untuk memindai QRIS ✦
                                    </p>
                                </div>

                                {{-- Panel 2: Holographic QRIS Shutter --}}
                                @if ($qrisUrl)
                                    <div onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                         role="button"
                                         tabindex="0"
                                         aria-label="Perbesar QRIS {{ $m->name }}"
                                         class="shutter-qris-panel absolute inset-0 hidden md:flex flex-col items-center justify-center p-3 rounded-2xl bg-gradient-to-b from-blue-50/95 via-white to-slate-50 border border-blue-200/80 shadow-inner cursor-pointer group/qr">
                                        
                                        {{-- Laser Scanner Shutter Sweep --}}
                                        <div class="pointer-events-none absolute inset-x-3 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent shadow-[0_0_10px_2px_rgba(59,130,246,0.85)] scanner-shutter-beam opacity-0 z-20"></div>

                                        {{-- Wadah QRIS Besar --}}
                                        <div class="w-full flex-1 max-h-[220px] flex items-center justify-center p-2 rounded-xl bg-white border border-slate-200/90 shadow-sm group-hover/qr:border-blue-400 group-hover/qr:shadow-md transition">
                                            <img src="{{ $qrisUrl }}"
                                                 alt="QRIS {{ $m->name }}"
                                                 class="w-full h-full max-h-[195px] object-contain select-none">
                                        </div>
                                        
                                        <span class="mt-2 text-[11px] font-extrabold text-blue-600 group-hover/qr:text-blue-700 flex items-center gap-1.5 shrink-0">
                                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                            Klik area ini untuk Perbesar / Unduh
                                        </span>
                                    </div>
                                @endif

                            </div>

                            {{-- Card Footer: Action Buttons --}}
                            <div class="relative z-10 pt-3 border-t border-slate-100 flex items-center gap-2">
                                <a href="{{ route('buyer.shop', $m->slug) }}" 
                                   class="flex-1 py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition text-center shadow-sm shadow-blue-600/20 flex items-center justify-center gap-1">
                                    <span>Lihat Menu</span>
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                
                                @if ($qrisUrl)
                                    <button type="button"
                                            onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                            title="Buka QRIS {{ $m->name }}"
                                            aria-label="Buka QRIS {{ $m->name }}"
                                            class="py-2.5 px-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200/80 text-xs font-extrabold transition cursor-pointer flex items-center gap-1">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                        <span>QRIS</span>
                                    </button>
                                @endif

                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                   title="Chat WhatsApp {{ $m->name }}"
                                   aria-label="Chat WhatsApp {{ $m->name }}"
                                   class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 text-xs font-extrabold transition text-center flex items-center justify-center">
                                    💬 WA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Horizontal Scroll Progress Track (Khusus Desktop) --}}
                <div class="hidden md:flex items-center justify-between gap-4 mt-3 pt-2 border-t border-slate-100 text-slate-400 text-[11px] font-bold">
                    <span class="flex items-center gap-1.5 text-blue-600">
                        <svg class="size-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Gunakan roda mouse atau klik panah untuk scroll horizontal
                    </span>
                    <div class="flex-1 max-w-xs h-1.5 rounded-full bg-slate-200/80 overflow-hidden">
                        <div id="rail-progress-bar" class="h-full bg-blue-600 rounded-full transition-all duration-150" style="width: 15%;"></div>
                    </div>
                    <span id="rail-counter-label" class="text-slate-600">1 / {{ $merchants->count() }} Lapak</span>
                </div>

            </div>
        @endif
    </section>

    {{-- 3. MODAL ZOOM & DOWNLOAD QRIS --}}
    <div id="qris-zoom-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4"
         onclick="if (event.target === this) closeQrisModal()">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-blue-100 text-center animate-editorial-in">
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

            <div class="p-4 rounded-2xl bg-slate-50 border border-blue-100 inline-block mb-5 max-w-full">
                <img id="modal-qris-img" src="" alt="QRIS Zoom" class="w-72 sm:w-80 max-h-[380px] object-contain rounded-xl bg-white mx-auto shadow-sm p-2">
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
            playHapticSound('qris');
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
            playHapticSound('click');
            const modal = document.getElementById('qris-zoom-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        /* -----------------------------------------------------------
         * Web Audio Procedural Haptics & Sound FX (Awwwards SOTA Standard)
         * Zero External Assets • Microsecond Latency • Pure Synthesis
         * ----------------------------------------------------------- */
        let audioCtx = null;
        let isAudioEnabled = true;

        function getAudioContext() {
            if (!audioCtx) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    audioCtx = new AudioContextClass();
                }
            }
            if (audioCtx && audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function toggleAudioSynth() {
            isAudioEnabled = !isAudioEnabled;
            const icon = document.getElementById('audio-icon');
            const text = document.getElementById('audio-status-text');
            if (icon) icon.innerText = isAudioEnabled ? '🔈' : '🔇';
            if (text) text.innerText = isAudioEnabled ? 'Audio: Nyala' : 'Audio: Bisu';
            if (isAudioEnabled) {
                playHapticSound('click');
            }
        }

        function playHapticSound(type = 'click') {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const now = ctx.currentTime;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.connect(gain);
            gain.connect(ctx.destination);

            if (type === 'tick') {
                // Suara geseran reel kaset / scroll tick mekanikal
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(420, now);
                osc.frequency.exponentialRampToValueAtTime(140, now + 0.025);
                gain.gain.setValueAtTime(0.04, now);
                gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.025);
                osc.start(now);
                osc.stop(now + 0.025);
            } else if (type === 'hover') {
                // Suara pop kartu mengambang halus
                osc.type = 'sine';
                osc.frequency.setValueAtTime(780, now);
                osc.frequency.exponentialRampToValueAtTime(880, now + 0.04);
                gain.gain.setValueAtTime(0.025, now);
                gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.04);
                osc.start(now);
                osc.stop(now + 0.04);
            } else if (type === 'qris') {
                // Suara scanner digital futuristik (two-tone beep)
                osc.type = 'sine';
                osc.frequency.setValueAtTime(520, now);
                osc.frequency.setValueAtTime(1040, now + 0.04);
                gain.gain.setValueAtTime(0.06, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.12);
                osc.start(now);
                osc.stop(now + 0.12);
            } else {
                // Click default
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(600, now);
                osc.frequency.exponentialRampToValueAtTime(200, now + 0.03);
                gain.gain.setValueAtTime(0.05, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.03);
                osc.start(now);
                osc.stop(now + 0.03);
            }
        }

        /* -----------------------------------------------------------
         * Horizontal Rail Controller (Desktop Wheel to Horizontal + 3D Tilt)
         * ----------------------------------------------------------- */
        const railTrack = document.getElementById('merchant-rail-track');
        let lastPlayedTickPos = 0;

        function scrollRail(direction = 'right') {
            if (!railTrack) return;
            playHapticSound('tick');
            const scrollDistance = 330;
            railTrack.scrollBy({
                left: direction === 'right' ? scrollDistance : -scrollDistance,
                behavior: 'smooth'
            });
        }

        // Lompat langsung ke lapak tertentu via klik meteran tick (|||||||)
        function jumpToRailIndex(index) {
            if (!railTrack) return;
            playHapticSound('tick');
            const cards = railTrack.querySelectorAll('.merchant-bento-card');
            if (cards[index]) {
                cards[index].scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        if (railTrack && window.innerWidth >= 768) {
            // Konversi Scroll Vertikal Roda Mouse ke Horizontal Scroll secara Natural
            railTrack.addEventListener('wheel', (e) => {
                if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                    // Hanya hijack jika kursor berada tepat di atas rel kartu
                    e.preventDefault();
                    railTrack.scrollLeft += e.deltaY * 0.9;
                }
            }, { passive: false });

            // Update Progress Bar & Real-time 3D Tilt Effect
            railTrack.addEventListener('scroll', () => {
                const maxScroll = railTrack.scrollWidth - railTrack.clientWidth;
                if (maxScroll <= 0) return;

                const progress = Math.min(1, Math.max(0, railTrack.scrollLeft / maxScroll));
                const bar = document.getElementById('rail-progress-bar');
                if (bar) {
                    bar.style.width = Math.max(10, progress * 100) + '%';
                }

                // Bunyikan tick audio tiap berpindah kartu (~280px)
                if (Math.abs(railTrack.scrollLeft - lastPlayedTickPos) > 280) {
                    playHapticSound('tick');
                    lastPlayedTickPos = railTrack.scrollLeft;
                }

                // Update Progress Bar & Real-time 3D Tilt Effect
                const trackRect = railTrack.getBoundingClientRect();
                const trackCenter = trackRect.left + trackRect.width / 2;
                const cards = railTrack.querySelectorAll('.merchant-bento-card');
                const tickBars = document.querySelectorAll('.ruler-bar');

                let closestIndex = 0;
                let minDistance = Infinity;

                cards.forEach((card, index) => {
                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = cardRect.left + cardRect.width / 2;
                    const distFromCenter = cardCenter - trackCenter;
                    const normalizedDist = distFromCenter / (trackRect.width / 2); // -1 s.d. 1

                    if (Math.abs(distFromCenter) < minDistance) {
                        minDistance = Math.abs(distFromCenter);
                        closestIndex = index;
                    }

                    // Formula 3D Timbul (Parallax Depth):
                    const clampedDist = Math.max(-1.5, Math.min(1.5, normalizedDist));
                    const rotateY = clampedDist * -6; // Derajat miring
                    const scale = 1 - Math.abs(clampedDist) * 0.03;
                    const translateZ = Math.max(0, (1 - Math.abs(clampedDist)) * 20);

                    card.style.transform = `scale(${scale.toFixed(3)}) translateZ(${translateZ.toFixed(1)}px) rotateY(${rotateY.toFixed(2)}deg)`;
                });

                // Update Ruler Ticks (|||||||) Indicator
                tickBars.forEach((bar, idx) => {
                    if (idx === closestIndex) {
                        bar.className = 'ruler-bar block w-2 h-7 rounded-full bg-blue-600 scale-y-110 shadow-sm shadow-blue-500/50 transition-all duration-200';
                    } else if (Math.abs(idx - closestIndex) === 1) {
                        bar.className = 'ruler-bar block w-1.5 h-5 rounded-full bg-slate-400 transition-all duration-200';
                    } else {
                        bar.className = 'ruler-bar block w-1.5 h-4 rounded-full bg-slate-300 transition-all duration-200';
                    }
                });

                const badge = document.getElementById('ruler-index-badge');
                if (badge) {
                    badge.innerText = `${String(closestIndex + 1).padStart(2, '0')} / ${String(cards.length).padStart(2, '0')}`;
                }

                const counterLabel = document.getElementById('rail-counter-label');
                if (counterLabel) {
                    counterLabel.innerText = `${closestIndex + 1} / ${cards.length} Lapak`;
                }
            }, { passive: true });
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
