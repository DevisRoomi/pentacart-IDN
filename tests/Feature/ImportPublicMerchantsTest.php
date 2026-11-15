<?php

namespace Tests\Feature;

use App\Models\ImageBlob;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportPublicMerchantsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dry_run_does_not_fetch_images_or_write_records(): void
    {
        Http::preventStrayRequests();

        $this->artisan('merchants:import-public', ['--dry-run' => true])
            ->expectsOutput('Ready to import 10 public listings and QRIS images.')
            ->assertSuccessful();

        $this->assertDatabaseCount('merchants', 0);
        $this->assertDatabaseCount('image_blobs', 0);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_import_creates_public_listings_and_persists_qris_images_idempotently(): void
    {
        $fakeImage = UploadedFile::fake()->image('qris.png');
        $imageBytes = file_get_contents($fakeImage->getRealPath());

        Http::preventStrayRequests();
        Http::fake([
            'drive.google.com/*' => Http::response($imageBytes, 200, ['Content-Type' => 'image/png']),
        ]);

        $this->artisan('merchants:import-public')
            ->expectsOutput('Imported 10 public listings and QRIS images; skipped 0 claimed listings.')
            ->assertSuccessful();
        $this->artisan('merchants:import-public')
            ->expectsOutput('Imported 10 public listings and QRIS images; skipped 0 claimed listings.')
            ->assertSuccessful();

        $this->assertDatabaseCount('merchants', 10);
        $this->assertDatabaseCount('products', 14);
        $this->assertDatabaseCount('image_blobs', 10);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseHas('merchants', [
            'slug' => 'gorio-rio-asrama',
            'user_id' => null,
        ]);

        $merchant = Merchant::query()->where('slug', 'gorio-rio-asrama')->firstOrFail();
        $imageBlob = ImageBlob::query()->where('merchant_id', $merchant->id)->firstOrFail();

        $this->assertSame($imageBytes, $imageBlob->content);
        $imageResponse = $this->get($merchant->qrisImageUrl())
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png');
        $this->assertSame($imageBytes, $imageResponse->getContent());

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Gorio Rio');

        $this->get(route('buyer.shop', $merchant->slug))
            ->assertOk()
            ->assertSee('Gorio Rio');

        Http::assertSentCount(20);
    }

    public function test_import_does_not_replace_a_claimed_listing(): void
    {
        $owner = User::factory()->create();
        Merchant::create([
            'user_id' => $owner->id,
            'name' => 'Lapak yang sudah diklaim',
            'slug' => 'gorio-rio-asrama',
            'phone' => '6281234567890',
        ]);

        $fakeImage = UploadedFile::fake()->image('qris.png');
        $imageBytes = file_get_contents($fakeImage->getRealPath());

        Http::preventStrayRequests();
        Http::fake([
            'drive.google.com/*' => Http::response($imageBytes, 200, ['Content-Type' => 'image/png']),
        ]);

        $this->artisan('merchants:import-public')
            ->expectsOutput('Imported 9 public listings and QRIS images; skipped 1 claimed listings.')
            ->assertSuccessful();

        $this->assertDatabaseHas('merchants', [
            'slug' => 'gorio-rio-asrama',
            'name' => 'Lapak yang sudah diklaim',
            'user_id' => $owner->id,
        ]);
        $this->assertDatabaseCount('merchants', 10);
        $this->assertDatabaseCount('image_blobs', 9);
    }

    public function test_import_rejects_an_invalid_qris_image_before_writing_records(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'drive.google.com/*' => Http::response('not an image', 200, ['Content-Type' => 'text/plain']),
        ]);

        $this->artisan('merchants:import-public')
            ->expectsOutput('QRIS image is invalid or unsupported for gorio-rio-asrama.')
            ->assertExitCode(1);

        $this->assertDatabaseCount('merchants', 0);
        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('image_blobs', 0);
    }

    public function test_production_import_requires_explicit_force_option(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        Http::preventStrayRequests();

        $this->artisan('merchants:import-public')
            ->expectsOutput('Pass --force to import public listings in production.')
            ->assertExitCode(1);

        $this->assertDatabaseCount('merchants', 0);
    }
}
