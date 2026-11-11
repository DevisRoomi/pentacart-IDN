<x-layouts.app title="Menu Jualan - PentaCart IDN">
    <div class="py-2 sm:py-4 space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg shadow-blue-900/5">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full">
                        Dashboard Penjual
                    </span>
                    <span class="text-xs text-slate-400 font-mono">/ {{ $merchant->slug }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $merchant->name }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola daftar menu, harga, dan stok barang jualan tokomu.</p>
            </div>
        </div>

        <x-merchant.nav :merchant="$merchant" />

        <div class="glass-card rounded-3xl p-8 sm:p-12 text-center shadow-xs animate-editorial-in">
            <span class="inline-block px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 border border-indigo-200/60 rounded-full mb-3">
                Slot Integrasi Tim
            </span>
            <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">Modul Manajemen Menu (`ProductManager`)</h2>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-2 leading-relaxed">
                Halaman ini sedang disiapkan untuk komponen <code class="font-mono text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">Merchant\ProductManager</code> yang dikerjakan oleh <strong>Ahmad</strong>. Setelah Pull Request Ahmad masuk ke <code class="font-mono text-slate-700">main</code>, route ini langsung terhubung otomatis.
            </p>
            <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ route('merchant.profile') }}" class="text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 px-4 py-2.5 rounded-xl transition">
                    &larr; Kembali ke Profil & QRIS
                </a>
                <a href="{{ route('merchant.orders') }}" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-xs transition">
                    Lihat Pesanan Masuk &rarr;
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
