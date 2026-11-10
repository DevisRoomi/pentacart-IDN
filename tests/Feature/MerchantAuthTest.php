<?php

namespace Tests\Feature;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Merchant\ProfileSettings;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MerchantAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_user_and_merchant_and_redirects(): void
    {
        Livewire::test(Register::class)
            ->set('name', 'Budi Santoso')
            ->set('email', 'budi@kampus.id')
            ->set('password', 'secret123')
            ->set('password_confirmation', 'secret123')
            ->set('shop_name', 'Warung Budi IDN')
            ->set('phone', '081234567890')
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect(route('merchant.profile'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'budi@kampus.id']);
        $this->assertDatabaseHas('merchants', ['name' => 'Warung Budi IDN', 'phone' => '6281234567890']);
    }

    public function test_login_authenticates_and_redirects(): void
    {
        $user = User::factory()->create([
            'email' => 'test@kampus.id',
            'password' => bcrypt('password123'),
        ]);

        Merchant::create([
            'user_id' => $user->id,
            'name' => 'Toko Uji',
            'slug' => 'toko-uji',
            'phone' => '628999999999',
            'is_open' => true,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'test@kampus.id')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('merchant.profile'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_merchant_can_update_profile_and_toggle_status(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $merchant = Merchant::create([
            'user_id' => $user->id,
            'name' => 'Lapak Lama',
            'slug' => 'lapak-lama',
            'phone' => '628111111111',
            'is_open' => true,
        ]);

        $this->actingAs($user);

        $fakeQris = UploadedFile::fake()->image('qris.png');

        Livewire::test(ProfileSettings::class)
            ->set('name', 'Lapak Baru Sukses')
            ->set('phone', '085555555555')
            ->set('location', 'Gedung Ali Lt. 1')
            ->set('description', 'Kantin aneka cemilan')
            ->set('new_qris', $fakeQris)
            ->call('updateProfile')
            ->assertHasNoErrors();

        $merchant->refresh();
        $this->assertEquals('Lapak Baru Sukses', $merchant->name);
        $this->assertEquals('6285555555555', $merchant->phone);
        $this->assertEquals('Gedung Ali Lt. 1', $merchant->location);
        $this->assertNotNull($merchant->qris_image);
        Storage::disk('public')->assertExists($merchant->qris_image);

        // Test toggle open/closed
        Livewire::test(ProfileSettings::class)
            ->call('toggleOpen');

        $merchant->refresh();
        $this->assertFalse($merchant->is_open);
    }
}
