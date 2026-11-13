<?php

namespace App\Livewire\Merchant;

use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Pesanan Masuk - PentaCart IDN')]
class OrderHistory extends Component
{
    public Merchant $merchant;
    public string $search = '';
    public string $dateFilter = 'all'; // 'today' | 'all'

    public function mount(): void
    {
        $user = Auth::user();
        $merchant = $user?->merchant;

        if (! $merchant) {
            $merchant = Merchant::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Shop',
                'slug' => Str::slug($user->name . '-' . $user->id),
                'phone' => '6281234567890',
                'is_open' => true,
            ]);
        }

        $this->merchant = $merchant;
    }

    public function formatWhatsAppUrl(Order $order): ?string
    {
        if (! $order->buyer_phone) {
            return null;
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $order->buyer_phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if ($cleanPhone === '') {
            return null;
        }

        $message = "Halo {$order->buyer_name}, pesananmu ({$order->order_items}) sudah kami terima dan sedang diproses untuk diantar ke {$order->dorm_location}. Mohon ditunggu ya!";

        return 'https://wa.me/' . $cleanPhone . '?text=' . rawurlencode($message);
    }

    public function render()
    {
        $query = $this->merchant->orders()->latest('ordered_at');

        if ($this->dateFilter === 'today') {
            $query->whereDate('ordered_at', now()->timezone('Asia/Jakarta')->toDateString());
        }

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('buyer_name', 'like', $term)
                    ->orWhere('dorm_location', 'like', $term)
                    ->orWhere('order_items', 'like', $term);
            });
        }

        $orders = $query->get();

        return view('livewire.merchant.order-history', [
            'orders' => $orders,
        ]);
    }
}
