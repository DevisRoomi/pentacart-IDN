<?php

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Kelola Menu - PentaCart IDN')] class extends Component
{
    public string $name = '';

    public string $price = '';

    public string $description = '';

    public bool $is_available = true;

    public ?int $editingProductId = null;

    public string $editingPrice = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_available' => ['required', 'boolean'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama menu wajib diisi.',
            'name.max' => 'Nama menu maksimal 255 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus berupa angka bulat.',
            'price.min' => 'Harga minimal Rp1.',
            'price.max' => 'Harga terlalu besar.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'editingPrice.required' => 'Harga wajib diisi.',
            'editingPrice.integer' => 'Harga harus berupa angka bulat.',
            'editingPrice.min' => 'Harga minimal Rp1.',
            'editingPrice.max' => 'Harga terlalu besar.',
        ];
    }

    #[Computed]
    public function products(): Collection
    {
        return $this->merchant()->products()->latest()->get();
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->merchant()->products()->create($validated);

        $this->reset('name', 'price', 'description', 'is_available');
        session()->flash('status', 'Menu berhasil disimpan.');
    }

    public function startEditingPrice(int $productId): void
    {
        $product = $this->merchant()->products()->findOrFail($productId);

        $this->editingProductId = $product->id;
        $this->editingPrice = (string) $product->price;
    }

    public function updatePrice(): void
    {
        if ($this->editingProductId === null) {
            abort(404);
        }

        $validated = $this->validate(
            ['editingPrice' => ['required', 'integer', 'min:1', 'max:4294967295']],
            $this->messages(),
        );

        $this->merchant()
            ->products()
            ->findOrFail($this->editingProductId)
            ->update(['price' => $validated['editingPrice']]);

        $this->cancelEditingPrice();
        session()->flash('status', 'Harga menu berhasil diperbarui.');
    }

    public function cancelEditingPrice(): void
    {
        $this->reset('editingProductId', 'editingPrice');
    }

    public function toggleAvailability(int $productId): void
    {
        $product = $this->merchant()->products()->findOrFail($productId);
        $product->update(['is_available' => ! $product->is_available]);

        session()->flash('status', 'Status stok menu berhasil diperbarui.');
    }

    public function deleteProduct(int $productId): void
    {
        $this->merchant()->products()->findOrFail($productId)->delete();

        session()->flash('status', 'Menu berhasil dihapus.');
    }

    private function merchant(): Merchant
    {
        $merchant = Auth::user()?->merchant;

        abort_unless($merchant instanceof Merchant, 404);

        return $merchant;
    }
};
?>

<div class="space-y-6">
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-lg shadow-blue-900/5">
        <div class="mb-6">
            <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/60 rounded-full">
                Dashboard Penjual
            </span>
            <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Menu</h1>
            <p class="mt-1 text-sm text-slate-500">Tambahkan dan atur menu yang tersedia di lapakmu.</p>
        </div>

        @if (session()->has('status'))
            <div role="status" class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-800 text-sm font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-4">
            <div>
                <label for="product-name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Menu</label>
                <input id="product-name" type="text" wire:model="name" maxlength="255"
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                @error('name') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="product-price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga (Rp)</label>
                <input id="product-price" type="number" wire:model="price" min="1" step="1"
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                @error('price') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="product-description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi</label>
                <textarea id="product-description" wire:model="description" rows="3" maxlength="1000"
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
                @error('description') <span class="text-[11px] text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <label for="product-available" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input id="product-available" type="checkbox" wire:model="is_available"
                    class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Tersedia
            </label>

            <button type="submit"
                class="w-full sm:w-auto py-3 px-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-600/30 transition cursor-pointer disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Simpan Menu</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </form>
    </div>

    <section class="glass-card rounded-3xl p-6 sm:p-8 shadow-md shadow-blue-900/5">
        <div class="flex items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Daftar Menu</h2>
            <span class="text-xs font-semibold text-slate-500">{{ $this->products->count() }} menu</span>
        </div>

        @forelse ($this->products as $product)
            <article wire:key="product-{{ $product->id }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-b border-slate-100 last:border-b-0">
                <div class="min-w-0">
                    <h3 class="font-bold text-slate-900">{{ $product->name }}</h3>
                    <span @class([
                        'mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-emerald-50 text-emerald-700' => $product->is_available,
                        'bg-slate-100 text-slate-600' => ! $product->is_available,
                    ])>
                        {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                    </span>
                    @if ($product->description)
                        <p class="mt-1 text-sm text-slate-500">{{ $product->description }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    @if ($editingProductId === $product->id)
                        <form wire:submit="updatePrice" class="flex items-center gap-2">
                            <label for="editing-price-{{ $product->id }}" class="sr-only">Harga {{ $product->name }}</label>
                            <input id="editing-price-{{ $product->id }}" type="number" wire:model="editingPrice" min="1" step="1"
                                class="w-32 px-3 py-2 rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none">
                            <button type="submit"
                                class="px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition cursor-pointer">
                                Simpan
                            </button>
                            <button type="button" wire:click="cancelEditingPrice"
                                class="px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition cursor-pointer">
                                Batal
                            </button>
                        </form>
                        @error('editingPrice') <span class="basis-full text-xs text-rose-500 font-medium">{{ $message }}</span> @enderror
                    @else
                        <p class="text-sm font-semibold text-blue-700">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <button type="button" wire:click="startEditingPrice({{ $product->id }})"
                            class="px-3 py-2 rounded-xl border border-blue-200 text-blue-700 hover:bg-blue-50 text-sm font-semibold transition cursor-pointer">
                            Ubah Harga
                        </button>
                    @endif
                    <button type="button" wire:click="toggleAvailability({{ $product->id }})"
                        class="px-3 py-2 rounded-xl border border-emerald-200 text-emerald-700 hover:bg-emerald-50 text-sm font-semibold transition cursor-pointer">
                        {{ $product->is_available ? 'Tandai Habis' : 'Tandai Tersedia' }}
                    </button>
                    <button type="button" wire:click="deleteProduct({{ $product->id }})" wire:confirm="Yakin ingin menghapus menu ini?"
                        class="px-3 py-2 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-sm font-semibold transition cursor-pointer">
                        Hapus
                    </button>
                </div>
            </article>
        @empty
            <p class="py-8 text-center text-sm text-slate-500">Belum ada menu. Tambahkan menu pertamamu melalui formulir di atas.</p>
        @endforelse
    </section>
</div>