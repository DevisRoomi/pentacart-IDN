<?php

namespace App\Console\Commands;

use App\Models\ImageBlob;
use App\Models\Merchant;
use App\Support\ImageDataUrl;
use Database\Seeders\StudentMerchantSeeder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

#[Signature('merchants:import-public {--dry-run} {--force}')]
#[Description('Import unclaimed student shops and their QRIS images')]
class ImportPublicMerchants extends Command
{
    public function handle(): int
    {
        $listings = StudentMerchantSeeder::listings();

        if ($this->option('dry-run')) {
            $this->info('Ready to import '.count($listings).' public listings and QRIS images.');

            return self::SUCCESS;
        }

        if (app()->environment('production') && ! $this->option('force')) {
            $this->error('Pass --force to import public listings in production.');

            return self::FAILURE;
        }

        $images = [];
        $skipped = [];

        foreach ($listings as $listing) {
            $merchant = Merchant::query()->where('slug', $listing['slug'])->first();

            if ($merchant?->user_id !== null) {
                $skipped[$listing['slug']] = true;

                continue;
            }

            $response = Http::connectTimeout(5)
                ->timeout(20)
                ->get('https://drive.google.com/uc', [
                    'export' => 'download',
                    'id' => $listing['qris_drive_id'],
                ])
                ->throw();

            $content = $response->body();
            $mimeType = strtolower(trim(explode(';', (string) $response->header('Content-Type'), 2)[0]));

            if (strlen($content) > ImageDataUrl::MAX_BYTES) {
                $this->error("QRIS image exceeds 2 MB for {$listing['slug']}.");

                return self::FAILURE;
            }

            $image = ImageDataUrl::parse(
                'data:'.$mimeType.';base64,'.base64_encode($content),
                ['image/jpeg', 'image/png', 'image/webp'],
            );

            if ($image === null) {
                $this->error("QRIS image is invalid or unsupported for {$listing['slug']}.");

                return self::FAILURE;
            }

            $images[$listing['slug']] = $image;
        }

        DB::transaction(function () use ($listings, $images, &$skipped): void {
            app(StudentMerchantSeeder::class)->run();

            foreach ($listings as $listing) {
                $merchant = Merchant::query()->where('slug', $listing['slug'])->firstOrFail();

                if ($merchant->user_id !== null) {
                    $skipped[$listing['slug']] = true;

                    continue;
                }

                $image = $images[$listing['slug']];

                ImageBlob::updateOrCreate(
                    ['merchant_id' => $merchant->id],
                    [
                        'mime_type' => $image->mimeType,
                        'content_hash' => $image->contentHash,
                        'content' => $image->content,
                    ],
                );
            }
        });

        $skippedCount = count($skipped);

        $this->info('Imported '.(count($listings) - $skippedCount).' public listings and QRIS images; skipped '.$skippedCount.' claimed listings.');

        return self::SUCCESS;
    }
}
