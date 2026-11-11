@props(['merchant'])

@php
    $todayOrdersCount = $merchant->orders()
        ->whereDate('ordered_at', now()->timezone('Asia/Jakarta')->toDateString())
        ->count();
    $activeProductsCount = $merchant->products()->where('is_available', true)->count();
@endphp

<div class="space-y-5 animate-editorial-in">
    {{-- 3 Stat Cards Editorial --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
        <div class="glass-card glass-card-hover rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pesanan Hari Ini</span>
                <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $todayOrdersCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-extrabold text-sm">
                #
            </div>
        </div>

        <div class="glass-card glass-card-hover rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Menu Tersedia</span>
                <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $activeProductsCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-extrabold text-sm">
                M
            </div>
        </div>

        <div class="glass-card glass-card-hover rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Operasional</span>
                <p class="text-base font-extrabold mt-1 flex items-center gap-2 {{ $merchant->is_open ? 'text-emerald-600' : 'text-slate-500' }}">
                    <span class="w-2.5 h-2.5 rounded-full {{ $merchant->is_open ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                    {{ $merchant->is_open ? 'Lapak Buka' : 'Lapak Tutup' }}
                </p>
            </div>
            <div class="text-[10px] font-mono text-slate-400 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">
                WIB
            </div>
        </div>
    </div>

    {{-- Tab Navigation Pill Bar --}}
    <div class="glass-card rounded-2xl p-1.5 flex items-center gap-1.5 overflow-x-auto shadow-xs">
        <a href="{{ route('merchant.profile') }}"
           class="flex-1 min-w-[130px] text-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all {{ request()->routeIs('merchant.profile') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/25' : 'text-slate-600 hover:bg-blue-50/70 hover:text-blue-700' }}">
            Profil & QRIS
        </a>

        <a href="{{ route('merchant.products') }}"
           class="flex-1 min-w-[130px] text-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all {{ request()->routeIs('merchant.products') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/25' : 'text-slate-600 hover:bg-blue-50/70 hover:text-blue-700' }}">
            Menu Jualan
        </a>

        <a href="{{ route('merchant.orders') }}"
           class="flex-1 min-w-[130px] text-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all {{ request()->routeIs('merchant.orders') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/25' : 'text-slate-600 hover:bg-blue-50/70 hover:text-blue-700' }}">
            Pesanan Masuk
        </a>
    </div>
</div>
