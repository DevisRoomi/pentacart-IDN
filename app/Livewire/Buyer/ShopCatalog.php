<?php

namespace App\Livewire\Buyer;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Katalog Menu Jajanan - PentaCart IDN')]
class ShopCatalog extends Component
{
    public Merchant $merchant;

    public string $search = '';

    /**
     * Keranjang belanja dalam format: [productId => quantity]
     */
    public array $cart = [];

    // Form data pengiriman asrama
    public string $buyer_name = '';
    public string $buyer_phone = '';
    public string $dorm_location = '';
    public string $notes = '';

    // Modal QRIS & Modal Keranjang / Checkout HP
    public bool $showQrisModal = false;
    public bool $showMobileCartModal = false;

    // Status setelah checkout
    public bool $orderSuccess = false;
    public ?string $waUrl = null;
    public ?int $latestOrderId = null;

    protected function rules(): array
    {
        return [
            'buyer_name' => 'required|string|min:2|max:100',
            'buyer_phone' => ['required', 'regex:/^(\+62|62|08)[0-9]{8,13}$/'],
            'dorm_location' => 'required|string|min:3|max:150',
            'notes' => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'buyer_name.required' => 'Nama pemesan wajib diisi.',
            'buyer_name.min' => 'Nama minimal 2 karakter.',
            'buyer_phone.required' => 'Nomor WhatsApp pemesan wajib diisi.',
            'buyer_phone.regex' => 'Format nomor WhatsApp harus diawali 08, 62, atau +62.',
            'dorm_location.required' => 'Gedung dan nomor kamar asrama wajib diisi.',
            'dorm_location.min' => 'Tuliskan nama gedung dan kamar dengan jelas (min. 3 karakter).',
        ];
    }

    public function mount($merchant = null): void
    {
        if ($merchant instanceof Merchant) {
            $this->merchant = $merchant;
        } elseif (is_string($merchant)) {
            $this->merchant = Merchant::where('slug', $merchant)->firstOrFail();
        } else {
            $this->merchant = Merchant::where('is_open', true)->first() ?? Merchant::firstOrFail();
        }
    }

    /**
     * Tambah item ke keranjang
     */
    public function addToCart(int $productId): void
    {
        $product = Product::where('merchant_id', $this->merchant->id)
            ->where('id', $productId)
            ->where('is_available', true)
            ->first();

        if (!$product) {
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]++;
        } else {
            $this->cart[$productId] = 1;
        }

        $this->resetErrorBag('cart');
    }

    /**
     * Kurangi item dari keranjang
     */
    public function decreaseCart(int $productId): void
    {
        if (!isset($this->cart[$productId])) {
            return;
        }

        $this->cart[$productId]--;

        if ($this->cart[$productId] <= 0) {
            unset($this->cart[$productId]);
        }
    }

    /**
     * Hapus item dari keranjang
     */
    public function removeFromCart(int $productId): void
    {
        unset($this->cart[$productId]);
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function clearCart(): void
    {
        $this->cart = [];
    }

    /**
     * Buka modal QRIS toko
     */
    public function openQrisModal(): void
    {
        $this->showQrisModal = true;
    }

    /**
     * Tutup modal QRIS toko
     */
    public function closeQrisModal(): void
    {
        $this->showQrisModal = false;
    }

    /**
     * Buka modal keranjang & checkout di layar HP
     */
    public function openMobileCart(): void
    {
        $this->showMobileCartModal = true;
    }

    /**
     * Tutup modal keranjang & checkout di layar HP
     */
    public function closeMobileCart(): void
    {
        $this->showMobileCartModal = false;
    }

    /**
     * Daftar item dalam keranjang beserta objek Product dan subtotal
     */
    #[Computed]
    public function cartItems()
    {
        if (empty($this->cart)) {
            return collect();
        }

        $productIds = array_keys($this->cart);
        $products = Product::where('merchant_id', $this->merchant->id)
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        return collect($this->cart)->map(function ($qty, $productId) use ($products) {
            $product = $products->get($productId);
            if (!$product) {
                return null;
            }

            return [
                'product' => $product,
                'qty' => $qty,
                'subtotal' => $product->price * $qty,
            ];
        })->filter()->values();
    }

    /**
     * Total harga seluruh keranjang
     */
    #[Computed]
    public function totalPrice(): int
    {
        return (int) $this->cartItems->sum('subtotal');
    }

    /**
     * Total jumlah jajanan yang dipilih
     */
    #[Computed]
    public function totalQuantity(): int
    {
        return (int) array_sum($this->cart);
    }

    /**
     * Daftar produk yang difilter pencarian
     */
    #[Computed]
    public function products()
    {
        return Product::where('merchant_id', $this->merchant->id)
            ->when(trim($this->search) !== '', function ($q) {
                $searchTerm = '%' . trim($this->search) . '%';
                $q->where(function ($sub) use ($searchTerm) {
                    $sub->where('name', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            })
            ->orderBy('is_available', 'desc')
            ->latest()
            ->get();
    }

    /**
     * Proses pemesanan via WhatsApp dan simpan ke database
     */
    public function orderViaWhatsApp()
    {
        if (!$this->merchant->is_open) {
            $this->addError('cart', 'Mohon maaf, lapak ini sedang tutup sementara.');
            return;
        }

        if (empty($this->cart) || $this->cartItems->isEmpty()) {
            $this->addError('cart', 'Keranjang belanja masih kosong. Silakan pilih menu jajanan terlebih dahulu.');
            return;
        }

        $this->validate();

        // Normalisasi nomor HP Pembeli
        $cleanBuyerPhone = preg_replace('/[^0-9]/', '', $this->buyer_phone);
        if (str_starts_with($cleanBuyerPhone, '0')) {
            $cleanBuyerPhone = '62' . substr($cleanBuyerPhone, 1);
        }

        // Normalisasi nomor HP Penjual
        $cleanMerchantPhone = preg_replace('/[^0-9]/', '', $this->merchant->phone);
        if (str_starts_with($cleanMerchantPhone, '0')) {
            $cleanMerchantPhone = '62' . substr($cleanMerchantPhone, 1);
        }

        // Susun detail order items untuk disimpan di DB
        $itemsData = $this->cartItems->map(function ($item) {
            return [
                'product_id' => $item['product']->id,
                'name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ];
        })->toArray();

        // Simpan Order ke Database
        $order = Order::create([
            'merchant_id' => $this->merchant->id,
            'buyer_name' => $this->buyer_name,
            'buyer_phone' => $cleanBuyerPhone,
            'dorm_location' => $this->dorm_location,
            'order_items' => json_encode($itemsData, JSON_UNESCAPED_UNICODE),
            'total_price' => $this->totalPrice,
            'notes' => $this->notes ?: null,
            'ordered_at' => now(),
        ]);

        // Susun teks pesan WhatsApp dengan format rapi dan terstruktur
        $waLines = [];
        $waLines[] = "Halo *" . $this->merchant->name . "*, saya ingin memesan jajanan via *PentaCart IDN* 🛒";
        $waLines[] = "";
        $waLines[] = "📋 *DETAIL PESANAN (Order #" . $order->id . "):*";

        foreach ($this->cartItems as $item) {
            $waLines[] = "• " . $item['product']->name . " (" . $item['qty'] . "x) - Rp " . number_format($item['subtotal'], 0, ',', '.');
        }

        $waLines[] = "------------------------------------";
        $waLines[] = "💰 *TOTAL:* Rp " . number_format($this->totalPrice, 0, ',', '.');
        $waLines[] = "";
        $waLines[] = "📍 *DATA PENGIRIMAN ASRAMA:*";
        $waLines[] = "• Nama: " . $this->buyer_name;
        $waLines[] = "• No. WA: " . $this->buyer_phone;
        $waLines[] = "• Gedung & Kamar: " . $this->dorm_location;
        if (!empty($this->notes)) {
            $waLines[] = "• Catatan: " . $this->notes;
        }
        $waLines[] = "";
        $waLines[] = "💳 *METODE PEMBAYARAN:* QRIS Lapak";
        $waLines[] = "_(Bukti pembayaran/transfer QRIS akan saya lampirkan segera pada chat ini)_";
        $waLines[] = "";
        $waLines[] = "Mohon diproses ya kak, terima kasih! 🙏";

        $fullWaText = implode("\n", $waLines);
        $waUrl = "https://wa.me/" . $cleanMerchantPhone . "?text=" . rawurlencode($fullWaText);

        $this->latestOrderId = $order->id;
        $this->waUrl = $waUrl;
        $this->orderSuccess = true;
        $this->showMobileCartModal = false;
        $this->cart = [];

        // Direct browser redirect ke WhatsApp
        return $this->redirect($waUrl, navigate: false);
    }

    /**
     * Reset order state untuk memesan lagi
     */
    public function resetOrder(): void
    {
        $this->orderSuccess = false;
        $this->waUrl = null;
        $this->latestOrderId = null;
        $this->showMobileCartModal = false;
        $this->cart = [];
    }

    public function render()
    {
        return view('livewire.buyer.shop-catalog', [
            'products' => $this->products,
            'cartItems' => $this->cartItems,
            'totalPrice' => $this->totalPrice,
            'totalQuantity' => $this->totalQuantity,
        ]);
    }
}
