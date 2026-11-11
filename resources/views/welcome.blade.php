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
                    Cari jajanan, nama penjual, atau kategori favoritmu. Arahkan kursor atau klik QRIS untuk scan langsung, lalu konfirmasi antar asrama via WhatsApp.
                </p>

                {{-- Search Bar Utama --}}
                <form action="{{ route('home') }}#katalog-lapak" method="GET" class="relative max-w-md mx-auto lg:mx-0">
                    <input type="text"
                           name="q"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari 'dimsum', 'es', 'mas devis', atau gedung..."
                           class="w-full pl-4 pr-24 py-3.5 text-sm rounded-2xl bg-white/95 border border-blue-200/80 focus:border-blue-600 focus:ring-4 focus:ring-blue-500/15 outline-none shadow-md shadow-blue-900/5 transition placeholder:text-slate-400">
                    <button type="submit"
                            class="absolute right-1.5 top-1.5 bottom-1.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition cursor-pointer">
                        Cari
                    </button>
                </form>

                {{-- Quick Keyword Pills --}}
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-1.5 text-[11px]">
                    <span class="text-slate-400 font-semibold mr-1">Cepat:</span>
                    @foreach (['Es', 'Dimsum', 'Kopi', 'Snack & Cemilan', 'Umar'] as $pill)
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

            {{-- Kanan: Panggung 3D QRIS Kampus Interaktif (1:1 ref + Mouse Parallax) --}}
            <div class="lg:col-span-7">
                <div id="hero-3d-stage"
                     class="relative mx-auto max-w-[540px] h-[360px] sm:h-[410px] rounded-[2rem] bg-gradient-to-b from-sky-50/95 via-blue-50/75 to-white/95 border border-blue-100/90 shadow-xl shadow-blue-900/10 overflow-hidden select-none"
                     style="perspective: 1200px;">

                    {{-- Ambient Glow + Campus Silhouette Background --}}
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_40%,rgba(59,130,246,0.18),transparent_62%)]"></div>
                    <svg class="absolute bottom-14 inset-x-0 w-full h-36 opacity-25 pointer-events-none" viewBox="0 0 540 140" fill="none">
                        <rect x="65" y="46" width="90" height="94" rx="4" fill="#93c5fd"/>
                        <rect x="175" y="24" width="190" height="116" rx="6" fill="#60a5fa"/>
                        <polygon points="165,26 270,4 375,26" fill="#3b82f6"/>
                        <rect x="242" y="14" width="56" height="14" rx="3" fill="#ffffff"/>
                        <text x="270" y="24" text-anchor="middle" font-size="8.5" font-weight="800" fill="#1d4ed8" letter-spacing="1">KAMPUS</text>
                        <rect x="385" y="46" width="90" height="94" rx="4" fill="#93c5fd"/>
                    </svg>
                    <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-white via-blue-50/70 to-transparent"></div>

                    {{-- Glowing Orbit Rings SVG --}}
                    <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 540 410" fill="none">
                        <ellipse cx="270" cy="198" rx="224" ry="94" transform="rotate(-10 270 198)"
                                 stroke="url(#orbitBlue)" stroke-width="1.8" class="orbit-dash opacity-85" />
                        <ellipse cx="270" cy="204" rx="190" ry="74" transform="rotate(8 270 204)"
                                 stroke="#60a5fa" stroke-opacity="0.38" stroke-width="1.2" />
                        <defs>
                            <linearGradient id="orbitBlue" x1="46" y1="198" x2="494" y2="198" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#93c5fd" stop-opacity="0.15" />
                                <stop offset="0.5" stop-color="#2563eb" stop-opacity="0.95" />
                                <stop offset="1" stop-color="#93c5fd" stop-opacity="0.15" />
                            </linearGradient>
                        </defs>
                    </svg>

                    {{-- Parallax Wrapper --}}
                    <div id="hero-3d-parallax" class="relative w-full h-full flex items-center justify-center transition-transform duration-150 ease-out" style="transform-style: preserve-3d;">

                        {{-- Tiered Circular Podiums --}}
                        <div class="absolute bottom-5 w-72 h-14 rounded-[100%] bg-gradient-to-r from-blue-600 via-blue-500 to-sky-100 shadow-lg shadow-blue-900/15 border border-white/70"></div>
                        <div class="absolute bottom-8 w-52 h-11 rounded-[100%] bg-gradient-to-b from-white to-blue-50 shadow-md shadow-blue-900/10 border border-blue-100"></div>

                        {{-- Center Smartphone Mockup --}}
                        <div class="relative z-20 -mt-3 w-[168px] sm:w-[180px] rounded-[1.85rem] bg-slate-900 p-1.5 shadow-[0_24px_48px_-12px_rgba(30,64,175,0.4)] border border-slate-700/80"
                             style="transform: rotateY(-6deg) rotateX(3deg);">
                            <div class="rounded-[1.5rem] bg-white px-3 pt-2.5 pb-3 text-center overflow-hidden">
                                <div class="flex items-center justify-between text-[8px] font-bold text-slate-400 mb-1.5 px-1">
                                    <span>9:41</span>
                                    <span class="w-10 h-2.5 rounded-full bg-slate-900 inline-block"></span>
                                    <span>WIB</span>
                                </div>

                                <div class="text-[11px] font-black tracking-tight text-blue-700 leading-none">QRIS</div>
                                <div class="text-[9px] font-bold text-slate-700 mt-0.5">Mahasiswa Kampus</div>

                                {{-- Scanner QR Box --}}
                                <div class="relative mx-auto mt-2.5 w-[104px] h-[104px] p-2 rounded-xl bg-slate-50 border border-blue-100 flex items-center justify-center">
                                    <span class="absolute top-1 left-1 w-3 h-3 border-t-2 border-l-2 border-blue-600 rounded-tl"></span>
                                    <span class="absolute top-1 right-1 w-3 h-3 border-t-2 border-r-2 border-blue-600 rounded-tr"></span>
                                    <span class="absolute bottom-1 left-1 w-3 h-3 border-b-2 border-l-2 border-blue-600 rounded-bl"></span>
                                    <span class="absolute bottom-1 right-1 w-3 h-3 border-b-2 border-r-2 border-blue-600 rounded-br"></span>

                                    <div class="scanner-beam absolute inset-x-2 top-0 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent shadow-[0_0_8px_#3b82f6]"></div>

                                    <svg viewBox="0 0 60 60" class="w-20 h-20">
                                        <rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="#1e3a8a" stroke-width="3"/>
                                        <rect x="9" y="9" width="6" height="6" rx="1" fill="#1e3a8a"/>
                                        <rect x="40" y="4" width="16" height="16" rx="2" fill="none" stroke="#1e3a8a" stroke-width="3"/>
                                        <rect x="45" y="9" width="6" height="6" rx="1" fill="#1e3a8a"/>
                                        <rect x="4" y="40" width="16" height="16" rx="2" fill="none" stroke="#1e3a8a" stroke-width="3"/>
                                        <rect x="9" y="45" width="6" height="6" rx="1" fill="#1e3a8a"/>
                                        <rect x="25" y="6" width="5" height="5" fill="#0f172a"/><rect x="32" y="12" width="5" height="5" fill="#0f172a"/>
                                        <rect x="6" y="25" width="5" height="5" fill="#0f172a"/><rect x="14" y="28" width="6" height="5" fill="#0f172a"/>
                                        <rect x="24" y="24" width="10" height="10" rx="2" fill="#2563eb"/>
                                        <rect x="38" y="26" width="6" height="6" fill="#0f172a"/><rect x="48" y="24" width="6" height="6" fill="#0f172a"/>
                                        <rect x="25" y="40" width="6" height="6" fill="#0f172a"/><rect x="35" y="42" width="6" height="5" fill="#0f172a"/>
                                        <rect x="44" y="40" width="10" height="6" fill="#0f172a"/><rect x="34" y="50" width="12" height="5" fill="#0f172a"/>
                                    </svg>
                                </div>

                                <div class="text-[8px] font-bold text-slate-500 mt-2">Satu QR, Semua Pembayaran</div>

                                {{-- 4 Bottom Circular Shortcuts --}}
                                <div class="grid grid-cols-4 gap-1 mt-2 pt-2 border-t border-slate-100">
                                    @foreach (['Kantin', 'Kopi', 'Snack', 'Lainnya'] as $mini)
                                        <div class="flex flex-col items-center">
                                            <span class="w-5 h-5 rounded-full border border-blue-200 bg-blue-50 text-blue-600 flex items-center justify-center text-[8px] font-extrabold">{{ substr($mini, 0, 1) }}</span>
                                            <span class="text-[6.5px] font-semibold text-slate-500 mt-0.5 truncate max-w-full">{{ $mini }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Foreground Left Prop: Tabletop QR Stand --}}
                        <div class="hidden sm:flex flex-col items-center absolute bottom-6 left-10 z-30 w-20 p-2 rounded-xl bg-white border border-blue-100 shadow-lg shadow-blue-900/15 -rotate-6 hover:rotate-0 transition-transform">
                            <span class="text-[8px] font-black text-blue-700">QRIS</span>
                            <div class="w-10 h-10 my-1 rounded bg-slate-100 border border-slate-200 grid grid-cols-3 gap-0.5 p-1">
                                <span class="bg-slate-800 rounded-xs"></span><span class="bg-transparent"></span><span class="bg-slate-800 rounded-xs"></span>
                                <span class="bg-transparent"></span><span class="bg-blue-600 rounded-xs"></span><span class="bg-transparent"></span>
                                <span class="bg-slate-800 rounded-xs"></span><span class="bg-slate-800 rounded-xs"></span><span class="bg-slate-800 rounded-xs"></span>
                            </div>
                            <span class="text-[7px] font-bold text-white bg-blue-600 px-1.5 py-0.5 rounded-full">Scan &amp; Bayar</span>
                        </div>

                        {{-- Foreground Right Prop: Student ID Card --}}
                        <div class="hidden sm:flex items-center gap-2 absolute bottom-7 right-10 z-30 px-3 py-2 rounded-xl bg-white border border-blue-100 shadow-lg shadow-blue-900/15 rotate-6 hover:rotate-0 transition-transform">
                            <div class="w-6 h-8 rounded bg-gradient-to-br from-blue-700 to-blue-500 flex items-end p-1">
                                <span class="text-[6px] font-extrabold text-white tracking-wider">IDN</span>
                            </div>
                            <div>
                                <div class="text-[8px] font-extrabold text-slate-800 leading-tight">Mahasiswa</div>
                                <div class="text-[6.5px] font-semibold text-blue-600">Asrama Delivery</div>
                            </div>
                        </div>

                        {{-- Floating Orbit Cards (Left Stack) --}}
                        <a href="{{ route('home', ['q' => 'Makanan Berat']) }}#katalog-lapak"
                           class="hero-float-a absolute left-3 sm:left-5 top-8 z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">K</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Kantin</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                        <a href="{{ route('home', ['q' => 'Dimsum']) }}#katalog-lapak"
                           class="hero-float-b absolute left-2 sm:left-4 top-[142px] z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition" style="animation-delay: 0.7s;">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">D</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Dimsum Corner</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                        <a href="{{ route('home', ['q' => 'Minuman & Es']) }}#katalog-lapak"
                           class="hero-float-a absolute left-4 sm:left-7 bottom-24 z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition" style="animation-delay: 1.3s;">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">E</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Minuman &amp; Es</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                        {{-- Floating Orbit Cards (Right Stack) --}}
                        <a href="{{ route('home', ['q' => 'Kopi']) }}#katalog-lapak"
                           class="hero-float-b absolute right-3 sm:right-5 top-8 z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition" style="animation-delay: 0.4s;">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">C</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Kopi Senja</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                        <a href="{{ route('home', ['q' => 'Snack & Cemilan']) }}#katalog-lapak"
                           class="hero-float-a absolute right-2 sm:right-4 top-[142px] z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition" style="animation-delay: 1.1s;">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">S</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Snack Asrama</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                        <a href="{{ route('home', ['q' => 'Kuliner Malam']) }}#katalog-lapak"
                           class="hero-float-b absolute right-4 sm:right-7 bottom-24 z-30 flex items-center gap-2.5 px-3 py-2 rounded-2xl bg-white/95 border border-white shadow-[0_12px_28px_rgba(29,78,216,0.14)] hover:scale-105 hover:border-blue-300 transition" style="animation-delay: 1.6s;">
                            <span class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">M</span>
                            <div class="leading-tight">
                                <div class="text-[11px] font-extrabold text-slate-900">Kuliner Malam</div>
                                <div class="text-[8px] font-bold text-blue-600">QRIS</div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. BARISAN QRIS & DAFTAR LAPAK KAMPUS --}}
    <section id="katalog-lapak" class="pt-4 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 pb-2 border-b border-blue-100/80">
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
            <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200/70 px-3 py-1 rounded-full self-start sm:self-auto">
                {{ $merchants->count() }} Lapak Terdaftar
            </span>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:pt-8">
                @foreach ($merchants as $m)
                    @php
                        $op = $m->operationalStatus();
                        $qrisUrl = $m->qris_image ? asset('storage/' . $m->qris_image) : null;
                        $waChatText = rawurlencode("Halo {$m->name}, saya lihat lapaknya di PentaCart IDN. Mau tanya / pesan ya!");
                        $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $m->phone) . '?text=' . $waChatText;
                    @endphp

                    <article class="qris-pop-stage glass-card glass-card-hover rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                        {{-- Pop-out QRIS Drawer (Visible on mobile top; pops smoothly from behind on desktop hover) --}}
                        <div class="mb-4 md:mb-0 md:absolute md:-top-36 md:inset-x-4 md:z-30 qris-pop-drawer">
                            <div class="rounded-2xl bg-white border border-blue-200/80 shadow-xl shadow-blue-900/15 p-3 flex flex-col items-center">
                                @if ($qrisUrl)
                                    <button type="button"
                                            onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                            class="group/qr relative w-full flex flex-col items-center cursor-pointer">
                                        <img src="{{ $qrisUrl }}"
                                             alt="QRIS {{ $m->name }}"
                                             class="w-36 h-36 md:w-32 md:h-32 object-contain rounded-xl bg-slate-50 border border-slate-100 p-1 group-hover/qr:scale-[1.03] transition-transform">
                                        <span class="mt-1.5 text-[10px] font-bold text-blue-600 group-hover/qr:underline">
                                            Klik untuk Perbesar / Download
                                        </span>
                                    </button>
                                @else
                                    <div class="w-full py-6 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center">
                                        <span class="text-[11px] font-bold text-slate-400">QRIS Belum Diunggah</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $op['open'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $op['open'] ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                    {{ $op['label'] }}
                                </span>

                                @if ($qrisUrl)
                                    <button type="button"
                                            onclick="openQrisModal({{ Js::from($m->name) }}, {{ Js::from($qrisUrl) }}, {{ Js::from($waUrl) }}, {{ Js::from($m->location ?? 'Kampus IDN') }}, {{ Js::from($op['label']) }})"
                                            class="hidden md:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-[10px] font-extrabold border border-blue-200/70 transition cursor-pointer">
                                        QRIS
                                    </button>
                                @endif
                            </div>

                            @if ($op['hint'])
                                <p class="text-[10px] font-bold {{ $op['open'] ? 'text-emerald-600' : 'text-amber-600' }} mb-1">
                                    {{ $op['hint'] }}
                                </p>
                            @endif

                            <h3 class="font-black text-lg text-slate-900 tracking-tight leading-snug">{{ $m->name }}</h3>

                            @if ($m->location)
                                <p class="text-[11px] font-semibold text-blue-700 mt-0.5">{{ $m->location }}</p>
                            @endif

                            <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                {{ $m->description ?? 'Lapak resmi mahasiswa kampus IDN.' }}
                            </p>

                            {{-- Mini Preview Menu --}}
                            @if ($m->products->isNotEmpty())
                                <div class="mt-3 pt-3 border-t border-slate-100 space-y-1">
                                    @foreach ($m->products->take(2) as $prod)
                                        <div class="flex items-center justify-between text-[11px]">
                                            <span class="text-slate-700 font-medium truncate pr-2">{{ $prod->name }}</span>
                                            <span class="font-bold text-slate-900 shrink-0">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer Actions (Chat WA selalu aktif!) --}}
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
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
            if (stage && parallax && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                stage.addEventListener('pointermove', (e) => {
                    const rect = stage.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width - 0.5) * 18;
                    const y = ((e.clientY - rect.top) / rect.height - 0.5) * -14;
                    parallax.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeQrisModal();
        });
    </script>
</x-layouts.app>
