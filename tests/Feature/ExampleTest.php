<?php

namespace Tests\Feature;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Satu Hub QRIS Mahasiswa IDN');
    }

    public function test_landing_page_displays_qris_cards_search_and_active_wa_chat_even_when_closed(): void
    {
        $owner = User::factory()->create(['name' => 'Bang Devis']);
        Merchant::create([
            'user_id' => $owner->id,
            'name' => 'Dimsum Asrama',
            'slug' => 'dimsum-asrama',
            'phone' => '6281234567890',
            'qris_image' => 'qris-images/demo-dimsum-corner-idn.svg',
            'keywords' => 'dimsum, makanan, umar',
            'is_open' => false,
            'schedule' => [['start' => '00:00', 'end' => '00:01']],
        ]);

        $res = $this->get('/?q=dimsum');
        $res->assertStatus(200);
        $res->assertSee('Dimsum Asrama');
        $res->assertSee('Scan QRIS');
        $res->assertSee('Chat WA');
        $res->assertSee('https://wa.me/6281234567890');
    }

    public function test_landing_page_can_filter_open_only(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $openMerchant = Merchant::create([
            'user_id' => $user1->id,
            'name' => 'Lapak Buka Terus',
            'slug' => 'lapak-buka-terus',
            'phone' => '628111111112',
            'is_open' => true,
            'schedule' => null,
        ]);

        $closedMerchant = Merchant::create([
            'user_id' => $user2->id,
            'name' => 'Lapak Tutup Dulu',
            'slug' => 'lapak-tutup-dulu',
            'phone' => '628222222223',
            'is_open' => false,
            'schedule' => null,
        ]);

        $response = $this->get('/?open_only=1');

        $response->assertStatus(200);
        $response->assertSee('Lapak Buka Terus');
        $response->assertDontSee('Lapak Tutup Dulu');
    }
}
