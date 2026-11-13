<div class="py-2 sm:py-4 space-y-6">
    {{-- Header Banner --}}
    <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg shadow-blue-900/5">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full">
                    Dashboard Penjual
                </span>
                <span class="text-xs text-slate-400 font-mono">/ {{ $merchant->slug }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $merchant->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Rekap pesanan asrama yang masuk beserta kontak WhatsApp pembeli.</p>
        </div>

        <div class="text-right">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Tercatat</span>
            <span class="text-2xl font-black text-blue-600">{{ $orders->count() }} Order</span>
        </div>
    </div>

    <x-merchant.nav :merchant="$merchant" />

    {{-- Search & Filter Bar --}}
    <div class="glass-card rounded-2xl p-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-xs">
        <div class="relative flex-1">
            <input type="text"
                   wire:model.live.debounce.250ms="search"
                   placeholder="Cari nama pembeli, kamar asrama, atau item pesanan..."
                   class="w-full pl-4 pr-4 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition placeholder:text-slate-400">
        </div>

        <div class="flex items-center gap-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200/60 self-start sm:self-auto">
            <button type="button" wire:click="$set('dateFilter', 'all')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer {{ $dateFilter === 'all' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                Semua
            </button>
            <button type="button" wire:click="$set('dateFilter', 'today')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer {{ $dateFilter === 'today' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                Hari Ini
            </button>
        </div>
    </div>

    {{-- Orders List --}}
    @if ($orders->isEmpty())
        <div class="glass-card rounded-3xl p-10 text-center shadow-xs animate-editorial-in">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 font-black text-xl">
                0
            </div>
            <h2 class="text-base font-bold text-slate-800">Belum Ada Pesanan Ditemukan</h2>
            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                @if ($search !== '' || $dateFilter === 'today')
                    Coba ubah kata kunci pencarian atau pilih filter "Semua".
                @else
                    Setiap pembeli yang melakukan checkout pesan antar asrama akan tercatat otomatis di sini.
                @endif
            </p>
        </div>
    @else
        <div class="space-y-3.5 animate-editorial-in">
            @foreach ($orders as $order)
                @php
                    $waUrl = $this->formatWhatsAppUrl($order);
                @endphp
                <div class="glass-card glass-card-hover rounded-2xl p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-extrabold text-base text-slate-900">{{ $order->buyer_name }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                                {{ $order->dorm_location }}
                            </span>
                            <span class="text-[11px] font-mono text-slate-400">
                                {{ $order->ordered_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </span>
                        </div>

                        <p class="text-sm text-slate-700 font-medium">
                            {{ $order->order_items }}
                        </p>

                        @if ($order->notes)
                            <p class="text-xs text-slate-500 italic">
                                Catatan: "{{ $order->notes }}"
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between gap-3 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                        <div class="text-left md:text-right">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total</span>
                            <span class="text-lg font-black text-slate-900">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>

                        @if ($waUrl)
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs shadow-emerald-600/20 transition hover:scale-[1.02] active:scale-95">
                                Hubungi Pembeli via WA
                            </a>
                        @else
                            <span class="text-[11px] font-semibold text-slate-400 px-3 py-1.5 rounded-xl bg-slate-100">
                                Tanpa No. WA
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
