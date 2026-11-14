<?php

namespace Tests\Feature;

use App\Livewire\Buyer\ShopCatalog;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BuyerShopCatalogTest extends TestCase
{
    use RefreshDatabase;

    private Merchant $merchant;

    private Product $productA;

    private Product $productB;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->merchant = Merchant::create([
            'user_id' => $user->id,
            'name' => 'Kantin Asrama Apip',
            'slug' => 'kantin-asrama-apip',
            'phone' => '081234567890',
            'location' => 'Gedung Umar Lt. 1',
            'description' => 'Aneka cemilan dan minuman dingin',
            'is_open' => true,
        ]);

        $this->productA = Product::create([
            'merchant_id' => $this->merchant->id,
            'name' => 'Pisang Coklat Lumer',
            'price' => 5000,
            'description' => 'Pisang manis dengan balutan coklat leleh renyah',
            'is_available' => true,
        ]);

        $this->productB = Product::create([
            'merchant_id' => $this->merchant->id,
            'name' => 'Es Teh Solo Segar',
            'price' => 3000,
            'description' => 'Es teh wangi khas Solo ukuran jumbo',
            'is_available' => true,
        ]);
    }

    public function test_buyer_can_view_shop_catalog_page(): void
    {
        $response = $this->get(route('buyer.shop', $this->merchant->slug));

        $response->assertStatus(200);
        $response->assertSee('Kantin Asrama Apip');
        $response->assertSee('Pisang Coklat Lumer');
        $response->assertSee('Es Teh Solo Segar');
        $response->assertSee('Lihat QRIS Lapak');
        $response->assertSee('images/product-placeholder.svg');
    }

    public function test_buyer_sees_product_photo_and_fallback_for_products_without_a_photo(): void
    {
        $this->productA->update(['image' => 'products/pisang-coklat.jpg']);

        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->assertSee('storage/products/pisang-coklat.jpg')
            ->assertSee('images/product-placeholder.svg');
    }

    public function test_buyer_can_search_products_reactively(): void
    {
        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->assertSee('Pisang Coklat Lumer')
            ->assertSee('Es Teh Solo Segar')
            ->set('search', 'Pisang')
            ->assertSee('Pisang Coklat Lumer')
            ->assertDontSee('Es Teh Solo Segar')
            ->set('search', 'MenuTidakAda')
            ->assertSee('Menu Tidak Ditemukan');
    }

    public function test_buyer_can_add_modify_and_clear_cart(): void
    {
        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->call('addToCart', $this->productA->id)
            ->call('addToCart', $this->productA->id)
            ->call('addToCart', $this->productB->id)
            ->assertSet('cart', [
                $this->productA->id => 2,
                $this->productB->id => 1,
            ])
            ->assertSee('Rp 13.000') // (2 * 5000) + (1 * 3000) = 13000
            ->call('decreaseCart', $this->productA->id)
            ->assertSet('cart', [
                $this->productA->id => 1,
                $this->productB->id => 1,
            ])
            ->call('removeFromCart', $this->productB->id)
            ->assertSet('cart', [
                $this->productA->id => 1,
            ])
            ->call('clearCart')
            ->assertSet('cart', []);
    }

    public function test_buyer_can_toggle_qris_modal(): void
    {
        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->assertSet('showQrisModal', false)
            ->call('openQrisModal')
            ->assertSet('showQrisModal', true)
            ->assertSee('QRIS Pembayaran Lapak')
            ->call('closeQrisModal')
            ->assertSet('showQrisModal', false);
    }

    public function test_order_validation_fails_when_fields_are_missing(): void
    {
        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->call('addToCart', $this->productA->id)
            ->call('orderViaWhatsApp')
            ->assertHasErrors(['buyer_name', 'buyer_phone', 'dorm_location']);
    }

    public function test_order_fails_when_cart_is_empty(): void
    {
        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->set('buyer_name', 'Budi Santoso')
            ->set('buyer_phone', '081234567891')
            ->set('dorm_location', 'Gedung Ali Lt. 2 Kamar 201')
            ->call('orderViaWhatsApp')
            ->assertHasErrors(['cart']);
    }

    public function test_buyer_can_order_successfully_and_redirect_to_whatsapp(): void
    {
        $test = Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->call('addToCart', $this->productA->id)
            ->call('addToCart', $this->productB->id)
            ->set('buyer_name', 'Apip Kurniawan')
            ->set('buyer_phone', '085712345678')
            ->set('dorm_location', 'Gedung Usman Lt. 3 Kamar 310')
            ->set('notes', 'Tolong antarkan sebelum jam istirahat')
            ->call('orderViaWhatsApp');

        $test->assertHasNoErrors();

        // Cek pesanan tersimpan di database
        $this->assertDatabaseHas('orders', [
            'merchant_id' => $this->merchant->id,
            'buyer_name' => 'Apip Kurniawan',
            'buyer_phone' => '6285712345678',
            'dorm_location' => 'Gedung Usman Lt. 3 Kamar 310',
            'total_price' => 8000,
            'notes' => 'Tolong antarkan sebelum jam istirahat',
        ]);

        // Verifikasi URL redirect mengarah ke WhatsApp penjual (nomor 6281234567890)
        $this->assertNotNull($test->get('waUrl'));
        $this->assertStringContainsString('https://wa.me/6281234567890', $test->get('waUrl'));
        $this->assertStringContainsString('Apip', $test->get('waUrl'));
        $this->assertStringContainsString('Kurniawan', $test->get('waUrl'));
    }

    public function test_cannot_order_when_merchant_is_closed(): void
    {
        $this->merchant->update(['is_open' => false]);

        Livewire::test(ShopCatalog::class, ['merchant' => $this->merchant])
            ->call('addToCart', $this->productA->id)
            ->set('buyer_name', 'Budi')
            ->set('buyer_phone', '081234567890')
            ->set('dorm_location', 'Gedung Ali Kamar 102')
            ->call('orderViaWhatsApp')
            ->assertHasErrors(['cart']);

        $this->assertDatabaseCount('orders', 0);
    }
}
