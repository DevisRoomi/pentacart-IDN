<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentMerchantSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('kampus123');

        $students = [
            [
                'student_name' => 'Hammam Fauzul Adzim',
                'email' => 'hammam@pentacart.idn',
                'phone' => '6281455147800',
                'shop_name' => 'Gorio Rio Asrama',
                'slug' => 'gorio-rio-asrama',
                'category' => 'Minuman',
                'location' => 'Asrama Putra - Kamar 2',
                'description' => 'Minuman es gorio rio.',
                'keywords' => 'Minuman & Es, gorio rio, es blender, kamar 2, hammam',
                'schedule' => [
                    ['start' => '12:00', 'end' => '15:30'],
                ],
                'qris_file' => 'student-gorio-rio.jpg',
                'products' => [
                    ['name' => 'Gorio Rio Es', 'price' => 5000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Ghulam Zaky',
                'email' => 'ghulam@pentacart.idn',
                'phone' => '6281412135854',
                'shop_name' => 'Zaky Junk Food',
                'slug' => 'zaky-junk-food',
                'category' => 'Makanan Ringan',
                'location' => 'Asrama Putra',
                'description' => 'Junk food.',
                'keywords' => 'Snack & Cemilan, fast food, gorengan, ghulam',
                'schedule' => [
                    ['start' => '11:30', 'end' => '13:00'],
                    ['start' => '16:00', 'end' => '17:30'],
                ],
                'qris_file' => 'student-junk-food.png',
                'products' => [
                    ['name' => 'Junk Food', 'price' => 12000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Muhammad Maulana Arya Chandra',
                'email' => 'aryachandra@pentacart.idn',
                'phone' => '6282288705542',
                'shop_name' => 'Mie Arya Asrama',
                'slug' => 'mie-arya-asrama',
                'category' => 'Makanan Berat',
                'location' => 'Asrama Putra',
                'description' => 'Mie instan dan jasa masak ba\'da maghrib sampai 21.00. Pesan mie kuah usahakan bawa mangkok sendiri.',
                'keywords' => 'Makanan Berat, mie, jasa masak, asrama, arya',
                'schedule' => [
                    ['start' => '18:15', 'end' => '21:00'],
                ],
                'qris_file' => 'student-mie.png',
                'products' => [
                    ['name' => '1 Mie', 'price' => 6000, 'description' => null],
                    ['name' => '2 Mie', 'price' => 10000, 'description' => null],
                    ['name' => 'Jasa Masak', 'price' => 2000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Rafi Albani',
                'email' => 'rafi@pentacart.idn',
                'phone' => '6282298791015',
                'shop_name' => 'Basreng, Usus, Kacang',
                'slug' => 'basreng-usus-kacang',
                'category' => 'Makanan Ringan',
                'location' => 'Kamar Asrama',
                'description' => 'Siap antar sekitar Politeknik IDN.',
                'keywords' => 'Snack & Cemilan, basreng, usus, kacang, rafi',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-basreng-usus-kacang.jpg',
                'products' => [
                    ['name' => 'Basreng (3 pcs)', 'price' => 5000, 'description' => null],
                    ['name' => 'Usus (2 pcs)', 'price' => 5000, 'description' => null],
                    ['name' => 'Kacang (3 pcs)', 'price' => 5000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Muhammad Tsaqif Arhab',
                'email' => 'tsaqif@pentacart.idn',
                'phone' => '6282120856921',
                'shop_name' => 'Aqeepstore',
                'slug' => 'aqeepstore',
                'category' => 'Makanan Ringan',
                'location' => 'Kamar Asrama',
                'description' => 'Moring pedas & asin.',
                'keywords' => 'Snack & Cemilan, moring, pedas, asin, tsaqif',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-aqeepstore.jpg',
                'products' => [
                    ['name' => 'Moring Pedas & Asin', 'price' => 2000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Muhammad Nabil Rizkiarda',
                'email' => 'nabil@pentacart.idn',
                'phone' => '6282289224094',
                'shop_name' => 'Kripik Pisang Krispy',
                'slug' => 'kripik-pisang-krispy',
                'category' => 'Makanan Ringan',
                'location' => 'Asrama 4',
                'description' => 'Jasa antar lingkungan IDN.',
                'keywords' => 'Snack & Cemilan, keripik pisang, coklat, vanilla, greentea, asrama 4, nabil',
                'schedule' => [
                    ['start' => '07:00', 'end' => '23:00'],
                ],
                'qris_file' => 'student-kripik-pisang-krispy.png',
                'products' => [
                    ['name' => 'Keripik Pisang Rasa Coklat', 'price' => 2500, 'description' => null],
                    ['name' => 'Keripik Pisang Rasa Vanilla', 'price' => 2500, 'description' => null],
                    ['name' => 'Keripik Pisang Rasa Greentea', 'price' => 2500, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Dzulfathan',
                'email' => 'dzulfathan@pentacart.idn',
                'phone' => '6285814965129',
                'shop_name' => 'Roti AOKA',
                'slug' => 'roti-aoka',
                'category' => 'Makanan Ringan',
                'location' => 'Asrama 2',
                'description' => 'Roti AOKA siap santap.',
                'keywords' => 'Snack & Cemilan, roti aoka, asrama 2, dzulfathan',
                'schedule' => [
                    ['start' => '06:00', 'end' => '23:00'],
                ],
                'qris_file' => 'student-roti-aoka.jpg',
                'products' => [
                    ['name' => 'Roti AOKA', 'price' => 3000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Azhim',
                'email' => 'azhim@pentacart.idn',
                'phone' => '6289541139369',
                'shop_name' => 'Ubilum',
                'slug' => 'ubilum',
                'category' => 'Makanan Ringan',
                'location' => 'Kos',
                'description' => 'Ubilum.',
                'keywords' => 'Snack & Cemilan, ubilum, kos, azhim',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-ubilum.jpg',
                'products' => [
                    ['name' => 'Ubilum', 'price' => 5000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Fauzan Rizky',
                'email' => 'fauzan@pentacart.idn',
                'phone' => '6285719496404',
                'shop_name' => 'Cordog',
                'slug' => 'cordog',
                'category' => 'Makanan Ringan',
                'location' => 'Sakan 1',
                'description' => 'Cordog.',
                'keywords' => 'Snack & Cemilan, cordog, sakan 1, fauzan',
                'schedule' => [
                    ['start' => '16:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-cordog.jpg',
                'products' => [
                    ['name' => 'Cordog', 'price' => 8000, 'description' => null],
                ],
            ],
            [
                'student_name' => 'Muhammad Azhar Habibillah',
                'email' => 'azhar@pentacart.idn',
                'phone' => '6285157166459',
                'shop_name' => 'Ceroxand Crisp Co.',
                'slug' => 'ceroxand-crisp-co',
                'category' => 'Makanan Ringan',
                'location' => 'Saung 1',
                'description' => 'Basreng Ceroxand.',
                'keywords' => 'Snack & Cemilan, basreng, saung 1, azhar',
                'schedule' => [
                    ['start' => '08:00', 'end' => '23:00'],
                ],
                'qris_file' => 'student-ceroxand-crisp-co.jpg',
                'products' => [
                    ['name' => 'Basreng (1 pcs)', 'price' => 1500, 'description' => null],
                    ['name' => 'Paket Murah Basreng (4 pcs)', 'price' => 5000, 'description' => null],
                ],
            ],
        ];

        foreach ($students as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['student_name'],
                    'password' => $defaultPassword,
                ]
            );

            $qrisRelativePath = 'qris-images/' . $data['qris_file'];

            $merchant = Merchant::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $user->id,
                    'name' => $data['shop_name'],
                    'phone' => $data['phone'],
                    'qris_image' => $qrisRelativePath,
                    'location' => $data['location'],
                    'description' => $data['description'],
                    'keywords' => $data['keywords'],
                    'is_open' => true,
                    'schedule' => $data['schedule'],
                ]
            );

            foreach ($data['products'] as $prod) {
                Product::updateOrCreate(
                    [
                        'merchant_id' => $merchant->id,
                        'name' => $prod['name'],
                    ],
                    [
                        'price' => $prod['price'],
                        'description' => $prod['description'],
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}
