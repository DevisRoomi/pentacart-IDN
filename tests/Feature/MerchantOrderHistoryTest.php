<?php

namespace Tests\Feature;

use App\Livewire\Merchant\OrderHistory;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MerchantOrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_merchant_only_sees_own_orders_and_can_filter_and_search(): void
    {
        $userA = User::factory()->create();
        $merchantA = Merchant::create([
            'user_id' => $userA->id,
            'name' => 'Lapak A',
            'slug' => 'lapak-a',
            'phone' => '628111111111',
            'is_open' => true,
        ]);

        $userB = User::factory()->create();
        $merchantB = Merchant::create([
            'user_id' => $userB->id,
            'name' => 'Lapak B',
            'slug' => 'lapak-b',
            'phone' => '628222222222',
            'is_open' => true,
        ]);

        Order::create([
            'merchant_id' => $merchantA->id,
            'buyer_name' => 'Rizky Asrama',
            'buyer_phone' => '085711223344',
            'dorm_location' => 'Gedung Usman 302',
            'order_items' => 'Dimsum x2',
            'total_price' => 24000,
            'ordered_at' => now()->timezone('Asia/Jakarta'),
        ]);

        Order::create([
            'merchant_id' => $merchantA->id,
            'buyer_name' => 'Hafidz Kemarin',
            'buyer_phone' => '081399887766',
            'dorm_location' => 'Gedung Ali 105',
            'order_items' => 'Gyoza x1',
            'total_price' => 15000,
            'ordered_at' => now()->timezone('Asia/Jakarta')->subDays(2),
        ]);

        Order::create([
            'merchant_id' => $merchantB->id,
            'buyer_name' => 'Rahasia Toko Lain',
            'buyer_phone' => '081200000000',
            'dorm_location' => 'Gedung Z 999',
            'order_items' => 'Kopi x1',
            'total_price' => 12000,
            'ordered_at' => now()->timezone('Asia/Jakarta'),
        ]);

        $this->actingAs($userA);

        Livewire::test(OrderHistory::class)
            ->assertSee('Rizky Asrama')
            ->assertSee('Hafidz Kemarin')
            ->assertDontSee('Rahasia Toko Lain')
            ->assertSee('https://wa.me/6285711223344?text=')
            ->set('dateFilter', 'today')
            ->assertSee('Rizky Asrama')
            ->assertDontSee('Hafidz Kemarin')
            ->set('dateFilter', 'all')
            ->set('search', 'Usman')
            ->assertSee('Rizky Asrama')
            ->assertDontSee('Hafidz Kemarin');
    }

    public function test_authenticated_merchant_can_access_dashboard_routes(): void
    {
        $user = User::factory()->create();
        Merchant::create([
            'user_id' => $user->id,
            'name' => 'Toko Test',
            'slug' => 'toko-test',
            'phone' => '6281234567890',
            'is_open' => true,
        ]);

        $this->actingAs($user);

        $this->get(route('merchant.profile'))->assertStatus(200);
        $this->get(route('merchant.products'))->assertStatus(200);
        $this->get(route('merchant.orders'))->assertStatus(200);
    }
}
