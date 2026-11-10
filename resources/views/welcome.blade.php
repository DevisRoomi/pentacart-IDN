<x-layouts.app title="PentaCart IDN - Katalog QRIS & Pesan Antar Asrama Mahasiswa">
    {{-- Hero Editorial --}}
    <div class="text-center max-w-2xl mx-auto py-6 sm:py-10">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full mb-3 shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
            Sentralisasi QRIS Mahasiswa Kampus
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
            Jajan di Asrama Jadi Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Praktis & Teratur</span>
        </h1>
        <p class="text-xs sm:text-base text-slate-500 mt-3 leading-relaxed">
            Semua lapak teman kampus dalam satu tempat. Scan QRIS langsung, pesan antar ke kamar asrama, dan konfirmasi otomatis ke WhatsApp tanpa ribet.
        </p>

        <div class="flex items-center justify-center gap-3 mt-6">
            <a href="#katalog-lapak" class="text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl shadow-md shadow-blue-600/30 transition hover:scale-[1.02] active:scale-95">
                Jelajahi Lapak
            </a>
            @guest
                <a href="{{ route('register') }}" class="text-xs sm:text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/80 px-5 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02] active:scale-95">
                    Mulai Buka Lapak
                </a>
            @endguest
        </div>
    </div>

    {{-- Value Props Pill Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-8">
        <div class="glass-card rounded-2xl p-4 flex items-center gap-3 shadow-xs">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                01
            </div>
            <div>
                <h2 class="text-xs font-bold text-slate-800">QRIS Terpusat</h2>
                <p class="text-[11px] text-slate-500">Gak perlu lagi minta QRIS satu-satu di WA.</p>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-4 flex items-center gap-3 shadow-xs">
            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                02
            </div>
            <div>
                <h2 class="text-xs font-bold text-slate-800">Antar ke Kamar</h2>
                <p class="text-[11px] text-slate-500">Input nomor kamar asrama untuk delivery.</p>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-4 flex items-center gap-3 shadow-xs">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                03
            </div>
            <div>
                <h2 class="text-xs font-bold text-slate-800">Auto Format WA</h2>
                <p class="text-[11px] text-slate-500">Pesan order langsung rapi dengan bukti bayar.</p>
            </div>
        </div>
    </div>

    {{-- Section Katalog Lapak --}}
    <div id="katalog-lapak" class="pt-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Daftar Lapak Kampus</h2>
                <p class="text-xs text-slate-500">Pilih lapak favoritmu dan cek ketersediaan menu.</p>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">
                {{ $merchants->count() }} Toko Terdaftar
            </span>
        </div>

        @if ($merchants->isEmpty())
            <div class="glass-card rounded-3xl p-8 sm:p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 font-bold text-2xl">
                    🏪
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Lapak Terdaftar</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-5">
                    Jadilah mahasiswa wirausaha pertama yang mendaftarkan lapak dan QRIS di kampus!
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-xs transition">
                    Daftar Jadi Penjual Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($merchants as $m)
                    <div class="glass-card rounded-2xl p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $m->is_open ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $m->is_open ? 'Buka' : 'Tutup' }}
                                </span>
                                @if ($m->location)
                                    <span class="text-[11px] text-slate-400 truncate max-w-[140px]">{{ $m->location }}</span>
                                @endif
                            </div>
                            <h3 class="font-extrabold text-base text-slate-900 tracking-tight">{{ $m->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $m->description ?? 'Lapak mahasiswa kampus IDN.' }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">{{ $m->products_count }} Menu Aktif</span>
                            <span class="font-bold text-blue-600">Lihat Lapak &rarr;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
