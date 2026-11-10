<div class="max-w-md mx-auto py-6 sm:py-12">
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-blue-900/5">
        <div class="text-center mb-6">
            <span class="inline-block px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full mb-2">
                Merchant Portal
            </span>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Lapak</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola QRIS, produk jualan, dan pesanan mahasiswa.</p>
        </div>

        <form wire:submit="login" class="space-y-4">
            {{-- Email --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Terdaftar</label>
                <input type="email" wire:model="email" placeholder="emailmu@kampus.ac.id" 
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white/90 border @error('email') border-rose-400 @else border-slate-200 @enderror focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition placeholder:text-slate-400">
                @error('email') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                <input type="password" wire:model="password" placeholder="••••••••" 
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white/90 border @error('password') border-rose-400 @else border-slate-200 @enderror focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                @error('password') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Ingat saya di perangkat ini</span>
                </label>
            </div>

            <button type="submit" 
                class="w-full mt-2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-bold text-sm shadow-md shadow-blue-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                <span wire:loading.remove>Masuk Sekarang</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    Memverifikasi...
                </span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-200/60 text-center text-xs text-slate-500">
            Belum punya lapak jualan? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                Buka lapak baru gratis
            </a>
        </div>
    </div>
</div>
