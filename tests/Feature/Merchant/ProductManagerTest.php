<?php

namespace Tests\Feature\Merchant;

use App\Models\Merchant;
use App\Models\User;
use App\Support\ImageDataUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProductManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('merchant.products'))
            ->assertRedirect(route('login'));
    }

    public function test_merchant_can_create_and_list_a_product(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);

        $this->actingAs($user);

        $this->get(route('merchant.products'))
            ->assertOk()
            ->assertSee('Kelola Menu');

        Livewire::test('merchant.product-manager')
            ->set('name', 'Nasi Goreng')
            ->set('price', '15000')
            ->set('description', 'Nasi goreng spesial')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Nasi Goreng')
            ->assertSee('Rp15.000')
            ->assertSee('images/product-placeholder.svg');

        $this->assertDatabaseHas('products', [
            'merchant_id' => $merchant->id,
            'name' => 'Nasi Goreng',
            'price' => 15000,
            'description' => 'Nasi goreng spesial',
            'is_available' => true,
        ]);
    }

    public function test_merchant_can_create_a_product_with_a_photo_saved_in_database(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $photo = UploadedFile::fake()->image('jajanan.png');
        $photoBytes = file_get_contents($photo->getRealPath());
        $photoDataUrl = 'data:image/png;base64,'.base64_encode($photoBytes);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->set('name', 'Pisang Goreng')
            ->set('price', '8000')
            ->set('photoData', $photoDataUrl)
            ->call('save')
            ->assertHasNoErrors();

        $product = $merchant->products()->where('name', 'Pisang Goreng')->firstOrFail();
        $imageBlob = $product->imageBlob()->firstOrFail();

        $this->assertNull($product->image);
        $this->assertSame('image/png', $imageBlob->mime_type);
        $this->assertSame(hash('sha256', $photoBytes), $imageBlob->content_hash);

        $response = $this->get($imageBlob->url())
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->assertSame($photoBytes, $response->getContent());
    }

    public function test_product_photo_must_be_an_allowed_image_format(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $photo = UploadedFile::fake()->create('menu.gif', 100, 'image/gif');
        $photoDataUrl = 'data:image/gif;base64,'.base64_encode(file_get_contents($photo->getRealPath()));

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->set('name', 'Pisang Goreng')
            ->set('price', '8000')
            ->set('photoData', $photoDataUrl)
            ->call('save')
            ->assertHasErrors(['photoData'])
            ->assertSee('Foto menu harus berformat JPG atau PNG.');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_photo_must_not_exceed_two_megabytes(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->set('name', 'Pisang Goreng')
            ->set('price', '8000')
            ->set('photoData', 'data:image/png;base64,'.str_repeat('A', 2_800_000))
            ->call('save')
            ->assertHasErrors(['photoData' => 'max'])
            ->assertSee('Ukuran foto menu maksimal 2MB.');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_photo_cannot_exceed_the_decoded_two_megabyte_limit(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $photo = UploadedFile::fake()->image('menu.png', 1, 1);
        $photoBytes = file_get_contents($photo->getRealPath());
        $oversizedBytes = str_pad($photoBytes, ImageDataUrl::MAX_BYTES + 1, "\0");

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->set('name', 'Pisang Goreng')
            ->set('price', '8000')
            ->set('photoData', 'data:image/png;base64,'.base64_encode($oversizedBytes))
            ->call('save')
            ->assertHasErrors(['photoData'])
            ->assertSee('Foto menu harus berformat JPG atau PNG.');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_photo_cannot_exceed_maximum_dimensions(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $photo = UploadedFile::fake()->image('menu.png', 8193, 1);
        $photoDataUrl = 'data:image/png;base64,'.base64_encode(file_get_contents($photo->getRealPath()));

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->set('name', 'Pisang Goreng')
            ->set('price', '8000')
            ->set('photoData', $photoDataUrl)
            ->call('save')
            ->assertHasErrors(['photoData'])
            ->assertSee('Foto menu harus berformat JPG atau PNG.');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_old_image_url_is_rejected_after_its_content_changes(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $product = $merchant->products()->create([
            'name' => 'Es Teh',
            'price' => 5000,
        ]);
        $imageBlob = $product->imageBlob()->create([
            'mime_type' => 'image/png',
            'content_hash' => str_repeat('a', 64),
            'content' => 'old image bytes',
        ]);
        $oldUrl = $imageBlob->url();

        $imageBlob->update([
            'content_hash' => str_repeat('b', 64),
            'content' => 'new image bytes',
        ]);

        $this->get($oldUrl)->assertNotFound();
    }

    public function test_merchant_can_update_their_product_price(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $product = $merchant->products()->create([
            'name' => 'Es Teh',
            'price' => 5000,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('startEditingPrice', $product->id)
            ->assertSet('editingPrice', '5000')
            ->set('editingPrice', '7500')
            ->call('updatePrice')
            ->assertHasNoErrors()
            ->assertSee('Rp7.500');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'merchant_id' => $merchant->id,
            'price' => 7500,
        ]);
    }

    public function test_product_price_update_rejects_prices_below_one_rupiah(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $product = $merchant->products()->create([
            'name' => 'Es Teh',
            'price' => 5000,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('startEditingPrice', $product->id)
            ->set('editingPrice', '0')
            ->call('updatePrice')
            ->assertHasErrors(['editingPrice' => 'min']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 5000,
        ]);
    }

    public function test_merchant_can_toggle_their_product_availability(): void
    {
        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $product = $merchant->products()->create([
            'name' => 'Pisang Goreng',
            'price' => 8000,
            'is_available' => true,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('toggleAvailability', $product->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'merchant_id' => $merchant->id,
            'is_available' => false,
        ]);

        Livewire::test('merchant.product-manager')
            ->call('toggleAvailability', $product->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_available' => true,
        ]);
    }

    public function test_product_form_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('save')
            ->assertHasErrors(['name' => 'required', 'price' => 'required']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_merchant_can_delete_their_product(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $merchant = $this->createMerchant($user);
        $imagePath = 'products/es-teh.jpg';
        Storage::disk('public')->put($imagePath, 'fake image');
        $product = $merchant->products()->create([
            'name' => 'Es Teh',
            'price' => 5000,
            'image' => $imagePath,
        ]);
        $imageBlob = $product->imageBlob()->create([
            'mime_type' => 'image/png',
            'content_hash' => str_repeat('a', 64),
            'content' => 'image bytes',
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('deleteProduct', $product->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('image_blobs', ['id' => $imageBlob->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_merchant_cannot_delete_another_merchants_product(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $otherMerchant = $this->createMerchant(User::factory()->create());
        $product = $otherMerchant->products()->create([
            'name' => 'Menu Rahasia',
            'price' => 10000,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('deleteProduct', $product->id)
            ->assertStatus(404);

        $this->assertModelExists($product);
    }

    public function test_merchant_cannot_edit_another_merchants_product_price(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $otherMerchant = $this->createMerchant(User::factory()->create());
        $product = $otherMerchant->products()->create([
            'name' => 'Menu Rahasia',
            'price' => 10000,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('startEditingPrice', $product->id)
            ->assertStatus(404);

        $this->assertModelExists($product);
    }

    public function test_merchant_cannot_toggle_another_merchants_product_availability(): void
    {
        $user = User::factory()->create();
        $this->createMerchant($user);
        $otherMerchant = $this->createMerchant(User::factory()->create());
        $product = $otherMerchant->products()->create([
            'name' => 'Menu Rahasia',
            'price' => 10000,
            'is_available' => true,
        ]);

        $this->actingAs($user);

        Livewire::test('merchant.product-manager')
            ->call('toggleAvailability', $product->id)
            ->assertStatus(404);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_available' => true,
        ]);
    }

    private function createMerchant(User $user): Merchant
    {
        return Merchant::create([
            'user_id' => $user->id,
            'name' => 'Toko '.$user->id,
            'slug' => 'toko-'.$user->id,
            'phone' => '6281234567890',
            'is_open' => true,
        ]);
    }
}
