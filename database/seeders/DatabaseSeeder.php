<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private function ensureDemoQrisSvg(string $slug, string $merchantName): string
    {
        $path = "qris-images/demo-{$slug}.svg";
        if (Storage::disk('public')->exists($path) && ! str_contains((string) Storage::disk('public')->get($path), '&bull;')) {
            return $path;
        }

        // Deterministic 11x11 QR matrix from slug hash (sharp, realistic, zero external API needed)
        $hash = md5($slug);
        $rects = '';
        $cell = 12;
        $offset = 44;

        for ($r = 0; $r < 11; $r++) {
            for ($c = 0; $c < 11; $c++) {
                $inTopLeft = ($r < 4 && $c < 4);
                $inTopRight = ($r < 4 && $c > 6);
                $inBottomLeft = ($r > 6 && $c < 4);
                if ($inTopLeft || $inTopRight || $inBottomLeft) {
                    continue;
                }
                $bit = hexdec($hash[($r * 11 + $c) % 32]) % 2 === 0;
                if ($bit) {
                    $x = $offset + $c * $cell;
                    $y = 64 + $r * $cell;
                    $rects .= "<rect x=\"{$x}\" y=\"{$y}\" width=\"10\" height=\"10\" rx=\"2\" fill=\"#0f172a\"/>";
                }
            }
        }

        $safeName = htmlspecialchars(mb_strimwidth($merchantName, 0, 26, '...'), ENT_QUOTES, 'UTF-8');
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 250" width="440" height="500">
  <rect width="220" height="250" rx="18" fill="#ffffff"/>
  <rect x="6" y="6" width="208" height="238" rx="14" fill="#f8fafc" stroke="#dbeafe" stroke-width="2"/>
  <text x="110" y="30" text-anchor="middle" font-family="sans-serif" font-size="13" font-weight="800" fill="#1d4ed8">QRIS PENTACART</text>
  <text x="110" y="46" text-anchor="middle" font-family="sans-serif" font-size="9" font-weight="600" fill="#475569">{$safeName}</text>
  <rect x="34" y="54" width="152" height="152" rx="12" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5"/>
  <rect x="44" y="64" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="55" y="75" width="16" height="16" rx="3" fill="#0f172a"/>
  <rect x="138" y="64" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="149" y="75" width="16" height="16" rx="3" fill="#0f172a"/>
  <rect x="44" y="158" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="55" y="169" width="16" height="16" rx="3" fill="#0f172a"/>
  {$rects}
  <text x="110" y="226" text-anchor="middle" font-family="sans-serif" font-size="9" font-weight="700" fill="#1e40af">SCAN &amp; BAYAR &#8226; IDN KAMPUS</text>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);

        return $path;
    }

    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Lapak Utama Demo (bisa dipakai Devis login untuk presentasi)
        $devisUser = User::firstOrCreate(
            ['email' => 'devis@pentacart.id'],
            ['name' => 'Devis Roomi', 'password' => $password]
        );

        $dimsumQris = $this->ensureDemoQrisSvg('dimsum-barokah-asrama', 'Dimsum Barokah Asrama');
        $dimsumSchedule = [
            ['start' => '13:00', 'end' => '14:30'],
            ['start' => '20:00', 'end' => '22:00'],
        ];

        $dimsumMerchant = Merchant::firstOrCreate(
            ['slug' => 'dimsum-barokah-asrama'],
            [
                'user_id' => $devisUser->id,
                'name' => 'Dimsum Barokah Asrama',
                'phone' => '6281234567890',
                'qris_image' => $dimsumQris,
                'location' => 'Asrama Umar Lt. 2 / Kamar 204',
                'description' => 'Dimsum ayam hangat, gyoza panggang, dan chili oil homemade khusus anak asrama.',
                'keywords' => 'Snack & Cemilan, Minuman & Es, es, dimsum, mas devis, umar',
                'is_open' => true,
                'schedule' => $dimsumSchedule,
            ]
        );
        $dimsumMerchant->update([
            'keywords' => $dimsumMerchant->keywords ?: 'Snack & Cemilan, Minuman & Es, es, dimsum, mas devis, umar',
            'qris_image' => $dimsumMerchant->qris_image ?: $dimsumQris,
            'schedule' => $dimsumMerchant->schedule ?: $dimsumSchedule,
        ]);

        $dimsumProducts = [
            ['name' => 'Dimsum Ayam Original (Isi 4)', 'price' => 12000, 'description' => 'Topping wortel & saus sambal bangkok.'],
            ['name' => 'Gyoza Panggang Chili Oil (Isi 4)', 'price' => 15000, 'description' => 'Gurih renyah dengan minyak cabai spesial.'],
            ['name' => 'Es Teh Kampus Jumbo', 'price' => 4000, 'description' => 'Manis pas dingin segar.'],
        ];

        foreach ($dimsumProducts as $p) {
            Product::firstOrCreate(
                ['merchant_id' => $dimsumMerchant->id, 'name' => $p['name']],
                ['price' => $p['price'], 'description' => $p['description'], 'is_available' => true]
            );
        }

        // Contoh pesanan masuk agar OrderHistory langsung terlihat hidup
        if ($dimsumMerchant->orders()->count() === 0) {
            Order::create([
                'merchant_id' => $dimsumMerchant->id,
                'buyer_name' => 'Rizky Pratama',
                'buyer_phone' => '6285711223344',
                'dorm_location' => 'Gedung Usman Lt. 3 / Kamar 302',
                'order_items' => 'Dimsum Ayam Original x2, Es Teh Kampus Jumbo x1',
                'total_price' => 28000,
                'notes' => 'Chili oil dipisah ya bang',
                'ordered_at' => now()->timezone('Asia/Jakarta')->subMinutes(18),
            ]);

            Order::create([
                'merchant_id' => $dimsumMerchant->id,
                'buyer_name' => 'Hafidz Ramadhan',
                'buyer_phone' => '6281399887766',
                'dorm_location' => 'Gedung Ali Lt. 1 / Kamar 105',
                'order_items' => 'Gyoza Panggang Chili Oil x1',
                'total_price' => 15000,
                'notes' => null,
                'ordered_at' => now()->timezone('Asia/Jakarta')->subDay(),
            ]);
        }

        // 2. Lapak Kedua
        $kopiUser = User::firstOrCreate(
            ['email' => 'kopi@pentacart.id'],
            ['name' => 'Fajar Kopi', 'password' => $password]
        );

        $kopiQris = $this->ensureDemoQrisSvg('kopi-senja-idn', 'Kopi Senja IDN');
        $kopiSchedule = [
            ['start' => '16:00', 'end' => '23:30'],
        ];

        $kopiMerchant = Merchant::firstOrCreate(
            ['slug' => 'kopi-senja-idn'],
            [
                'user_id' => $kopiUser->id,
                'name' => 'Kopi Senja IDN',
                'phone' => '6282188990011',
                'qris_image' => $kopiQris,
                'location' => 'Stand Teras Masjid Lt. 1',
                'description' => 'Kopi susu gula aren & matcha latte siap antar saat jam ngoding malam.',
                'keywords' => 'Kopi, Minuman & Es, es, minuman, matcha, mas fajar, ngoding',
                'is_open' => true,
                'schedule' => $kopiSchedule,
            ]
        );
        $kopiMerchant->update([
            'keywords' => $kopiMerchant->keywords ?: 'Kopi, Minuman & Es, es, minuman, matcha, mas fajar, ngoding',
            'qris_image' => $kopiMerchant->qris_image ?: $kopiQris,
            'schedule' => $kopiMerchant->schedule ?: $kopiSchedule,
        ]);

        Product::firstOrCreate(
            ['merchant_id' => $kopiMerchant->id, 'name' => 'Es Kopi Susu Gula Aren'],
            ['price' => 12000, 'description' => 'Espresso arabika + susu segar.', 'is_available' => true]
        );
        Product::firstOrCreate(
            ['merchant_id' => $kopiMerchant->id, 'name' => 'Matcha Latte Creamy'],
            ['price' => 14000, 'description' => 'Pure matcha uji Jepang.', 'is_available' => true]
        );

        // 3. Lapak Ketiga
        $snackUser = User::firstOrCreate(
            ['email' => 'snack@pentacart.id'],
            ['name' => 'Naufal Snack', 'password' => $password]
        );

        $snackQris = $this->ensureDemoQrisSvg('gorengan-risoles-malam', 'Risol Mayo & Gorengan');
        $snackSchedule = [
            ['start' => '19:30', 'end' => '23:00'],
        ];

        $snackMerchant = Merchant::firstOrCreate(
            ['slug' => 'gorengan-risoles-malam'],
            [
                'user_id' => $snackUser->id,
                'name' => 'Risol Mayo & Gorengan Malam',
                'phone' => '6287744556677',
                'qris_image' => $snackQris,
                'location' => 'Asrama Abu Bakar Kamar 112',
                'description' => 'Risol mayo lumer, tahu isi pedas, dan cireng bumbu rujak.',
                'keywords' => 'Snack & Cemilan, Kuliner Malam, gorengan, risol, naufal, abu bakar',
                'is_open' => true,
                'schedule' => $snackSchedule,
            ]
        );
        $snackMerchant->update([
            'keywords' => $snackMerchant->keywords ?: 'Snack & Cemilan, Kuliner Malam, gorengan, risol, naufal, abu bakar',
            'qris_image' => $snackMerchant->qris_image ?: $snackQris,
            'schedule' => $snackMerchant->schedule ?: $snackSchedule,
        ]);

        Product::firstOrCreate(
            ['merchant_id' => $snackMerchant->id, 'name' => 'Risol Mayo Smoked Beef (Isi 3)'],
            ['price' => 10000, 'description' => 'Mayo gurih dengan telur dan smoked beef.', 'is_available' => true]
        );
        // Panggil seeder 10 lapak data riil mahasiswa kampus IDN
        $this->call(StudentMerchantSeeder::class);
    }
}
