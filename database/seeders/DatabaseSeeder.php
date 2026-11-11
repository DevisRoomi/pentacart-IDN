<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Lapak Utama Demo (bisa dipakai Devis login untuk presentasi)
        $devisUser = User::firstOrCreate(
            ['email' => 'devis@pentacart.id'],
            ['name' => 'Devis Roomi', 'password' => $password]
        );

        $dimsumMerchant = Merchant::firstOrCreate(
            ['slug' => 'dimsum-barokah-asrama'],
            [
                'user_id' => $devisUser->id,
                'name' => 'Dimsum Barokah Asrama',
                'phone' => '6281234567890',
                'location' => 'Asrama Umar Lt. 2 / Kamar 204',
                'description' => 'Dimsum ayam hangat, gyoza panggang, dan chili oil homemade khusus anak asrama.',
                'keywords' => 'Snack & Cemilan, Minuman & Es, es, dimsum, mas devis, umar',
                'is_open' => true,
            ]
        );
        if (! $dimsumMerchant->keywords) {
            $dimsumMerchant->update(['keywords' => 'Snack & Cemilan, Minuman & Es, es, dimsum, mas devis, umar']);
        }

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

        $kopiMerchant = Merchant::firstOrCreate(
            ['slug' => 'kopi-senja-idn'],
            [
                'user_id' => $kopiUser->id,
                'name' => 'Kopi Senja IDN',
                'phone' => '6282188990011',
                'location' => 'Stand Teras Masjid Lt. 1',
                'description' => 'Kopi susu gula aren & matcha latte siap antar saat jam ngoding malam.',
                'keywords' => 'Kopi, Minuman & Es, es, minuman, matcha, mas fajar, ngoding',
                'is_open' => true,
            ]
        );
        if (! $kopiMerchant->keywords) {
            $kopiMerchant->update(['keywords' => 'Kopi, Minuman & Es, es, minuman, matcha, mas fajar, ngoding']);
        }

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

        $snackMerchant = Merchant::firstOrCreate(
            ['slug' => 'gorengan-risoles-malam'],
            [
                'user_id' => $snackUser->id,
                'name' => 'Risol Mayo & Gorengan Malam',
                'phone' => '6287744556677',
                'location' => 'Asrama Abu Bakar Kamar 112',
                'description' => 'Risol mayo lumer, tahu isi pedas, dan cireng bumbu rujak.',
                'keywords' => 'Snack & Cemilan, Kuliner Malam, gorengan, risol, naufal, abu bakar',
                'is_open' => false,
            ]
        );
        if (! $snackMerchant->keywords) {
            $snackMerchant->update(['keywords' => 'Snack & Cemilan, Kuliner Malam, gorengan, risol, naufal, abu bakar']);
        }

        Product::firstOrCreate(
            ['merchant_id' => $snackMerchant->id, 'name' => 'Risol Mayo Smoked Beef (Isi 3)'],
            ['price' => 10000, 'description' => 'Mayo gurih dengan telur dan smoked beef.', 'is_available' => true]
        );
    }
}
