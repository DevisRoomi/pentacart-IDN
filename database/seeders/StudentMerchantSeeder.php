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
                'description' => 'Minuman segar es gorio rio manis dingin untuk teman belajar siang hari.',
                'keywords' => 'Minuman & Es, gorio rio, es blender, kamar 2, hammam',
                'schedule' => [
                    ['start' => '12:00', 'end' => '15:30'],
                ],
                'qris_file' => 'student-gorio-rio.jpg',
                'products' => [
                    ['name' => 'Es Gorio Rio Coklat', 'price' => 5000, 'description' => 'Gorio rio diblender dingin dengan susu kental manis.'],
                    ['name' => 'Es Gorio Rio Vanilla Ekstra', 'price' => 6000, 'description' => 'Porsi ekstra dengan taburan remah gorio rio di atas.'],
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
                'description' => 'Jajanan cepat saji hangat dan camilan renyah pengganjal lapar waktu istirahat.',
                'keywords' => 'Snack & Cemilan, fast food, gorengan, cemilan santai, ghulam',
                'schedule' => [
                    ['start' => '11:30', 'end' => '13:00'],
                    ['start' => '16:00', 'end' => '17:30'],
                ],
                'qris_file' => 'student-junk-food.png',
                'products' => [
                    ['name' => 'Paket Jajanan Komplit', 'price' => 12000, 'description' => 'Porsi mengenyangkan siap santap di jam istirahat.'],
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
                'description' => 'Jasa masak mie instan kuah/goreng telor hangat ba\'da maghrib sampai malam. Bawa mangkok sendiri jika mie kuah.',
                'keywords' => 'Makanan Berat, mie instan, indomie, jasa masak, malam, arya',
                'schedule' => [
                    ['start' => '18:15', 'end' => '21:00'],
                ],
                'qris_file' => 'student-mie.png',
                'products' => [
                    ['name' => 'Mie Instan Single (Goreng/Kuah)', 'price' => 6000, 'description' => '1 bungkus mie instan dimasak pas.'],
                    ['name' => 'Mie Instan Double Porsi Kenyang', 'price' => 10000, 'description' => '2 bungkus mie instan campur.'],
                    ['name' => 'Jasa Masak Mie (Bawa Mie Sendiri)', 'price' => 2000, 'description' => 'Kamu bawa mie, kami yang masakkan sampai matang.'],
                ],
            ],
            [
                'student_name' => 'Rafi Albani',
                'email' => 'rafi@pentacart.idn',
                'phone' => '6282298791015',
                'shop_name' => 'Basreng, Usus & Kacang Rafi',
                'slug' => 'basreng-usus-kacang-rafi',
                'category' => 'Makanan Ringan',
                'location' => 'Kamar Asrama Putra',
                'description' => 'Camilan pedas gurih basreng renyah, usus krispi, dan kacang bawang. Siap antar sekitar kampus IDN.',
                'keywords' => 'Snack & Cemilan, basreng pedas, usus krispi, kacang, rafi',
                'schedule' => [
                    ['start' => '10:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-basreng-usus-kacang.jpg',
                'products' => [
                    ['name' => 'Basreng Pedas Gurih (3 Pcs)', 'price' => 5000, 'description' => 'Basreng iris tipis renyah bumbu daun jeruk.'],
                    ['name' => 'Usus Krispi Gurih (2 Pcs)', 'price' => 5000, 'description' => 'Usus goreng tepung renyah tanpa bau amis.'],
                    ['name' => 'Kacang Bawang Renyah (3 Pcs)', 'price' => 5000, 'description' => 'Kacang gurih asin teman begadang tugas.'],
                ],
            ],
            [
                'student_name' => 'Muhammad Tsaqif Arhab',
                'email' => 'tsaqif@pentacart.idn',
                'phone' => '6282120856921',
                'shop_name' => 'Aqeepstore',
                'slug' => 'aqeepstore',
                'category' => 'Makanan Ringan',
                'location' => 'Kamar Asrama Putra',
                'description' => 'Moring (cimol kering) renyah khas Sunda varian pedas dan asin gurih murah meriah.',
                'keywords' => 'Snack & Cemilan, moring, cimol kering, pedas asin, tsaqif',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:30'],
                ],
                'qris_file' => 'student-aqeepstore.jpg',
                'products' => [
                    ['name' => 'Moring Gurih Asin', 'price' => 2000, 'description' => 'Cimol kering renyah bumbu asin gurih.'],
                    ['name' => 'Moring Balado Pedas', 'price' => 2000, 'description' => 'Cimol kering renyah bumbu cabai pedas nagih.'],
                ],
            ],
            [
                'student_name' => 'Muhammad Nabil Rizkiarda',
                'email' => 'nabil@pentacart.idn',
                'phone' => '6282289224094',
                'shop_name' => 'Keripik Pisang Krispy Nabil',
                'slug' => 'keripik-pisang-krispy-nabil',
                'category' => 'Makanan Ringan',
                'location' => 'Asrama Putra Gedung 4',
                'description' => 'Keripik pisang aneka rasa lumur tebal (Coklat, Vanilla, Greentea). Jasa antar lingkungan kampus IDN.',
                'keywords' => 'Snack & Cemilan, keripik pisang, coklat, matcha, asrama 4, nabil',
                'schedule' => [
                    ['start' => '07:00', 'end' => '23:00'],
                ],
                'qris_file' => 'student-kripik-pisang-krispy.png',
                'products' => [
                    ['name' => 'Keripik Pisang Coklat Lumer', 'price' => 2500, 'description' => 'Keripik pisang renyah berbalut bubuk coklat premium.'],
                    ['name' => 'Keripik Pisang Vanilla Milky', 'price' => 2500, 'description' => 'Rasa susu vanilla manis wangi.'],
                    ['name' => 'Keripik Pisang Green Tea Matcha', 'price' => 2500, 'description' => 'Aroma matcha jepang manis gurih.'],
                ],
            ],
            [
                'student_name' => 'Dzulfathan',
                'email' => 'dzulfathan@pentacart.idn',
                'phone' => '6285814965129',
                'shop_name' => 'Roti AOKA Asrama 2',
                'slug' => 'roti-aoka-asrama-2',
                'category' => 'Makanan Ringan',
                'location' => 'Asrama Putra Gedung 2',
                'description' => 'Roti panggang AOKA lembut aneka rasa selai manis mengenyangkan. Stok selalu ready kapan saja.',
                'keywords' => 'Snack & Cemilan, roti aoka, roti panggang, sarapan, asrama 2, dzulfathan',
                'schedule' => [
                    ['start' => '06:30', 'end' => '23:00'],
                ],
                'qris_file' => 'student-roti-aoka.jpg',
                'products' => [
                    ['name' => 'Roti AOKA Aneka Rasa (Coklat/Keju/Blueberry)', 'price' => 3000, 'description' => 'Roti lembut selai melimpah siap santap kapan saja.'],
                ],
            ],
            [
                'student_name' => 'Azhim',
                'email' => 'azhim@pentacart.idn',
                'phone' => '6289541139369',
                'shop_name' => 'Ubilum Snack',
                'slug' => 'ubilum-snack',
                'category' => 'Makanan Ringan',
                'location' => 'Kos Sekitar Kampus IDN',
                'description' => 'Olahan ubi lumer manis legit camilan santai sore anak kos.',
                'keywords' => 'Snack & Cemilan, ubi lumer, ubilum, manis, azhim',
                'schedule' => [
                    ['start' => '15:00', 'end' => '21:00'],
                ],
                'qris_file' => 'student-ubilum.jpg',
                'products' => [
                    ['name' => 'Ubilum Crispy Lumer', 'price' => 5000, 'description' => 'Ubi manis berbalut tepung krispi dengan lelehan coklat.'],
                ],
            ],
            [
                'student_name' => 'Fauzan Rizky',
                'email' => 'fauzan@pentacart.idn',
                'phone' => '6285719496404',
                'shop_name' => 'Corndog Sakan 1',
                'slug' => 'corndog-sakan-1',
                'category' => 'Makanan Ringan',
                'location' => 'Sakan / Asrama 1',
                'description' => 'Corndog sosis mozarella panas lumer dengan saus sambal dan mayonaise melimpah.',
                'keywords' => 'Snack & Cemilan, corndog, mozarella, sosis, sakan 1, fauzan',
                'schedule' => [
                    ['start' => '16:00', 'end' => '22:00'],
                ],
                'qris_file' => 'student-cordog.jpg',
                'products' => [
                    ['name' => 'Corndog Mozarella Sosis', 'price' => 8000, 'description' => 'Keju mozarella tarik panjang dipadu sosis gurih renyah.'],
                ],
            ],
            [
                'student_name' => 'Muhammad Azhar Habibillah',
                'email' => 'azhar@pentacart.idn',
                'phone' => '6285157166459',
                'shop_name' => 'Ceroxand Crisp Co.',
                'slug' => 'ceroxand-crisp-co',
                'category' => 'Makanan Ringan',
                'location' => 'Saung 1 Kampus IDN',
                'description' => 'Basreng super krispi dengan sensasi pedas gurih nagih khas Ceroxand. Harga bersahabat.',
                'keywords' => 'Snack & Cemilan, basreng krispi, pedas daun jeruk, saung 1, azhar',
                'schedule' => [
                    ['start' => '08:00', 'end' => '23:00'],
                ],
                'qris_file' => 'student-ceroxand-crisp-co.jpg',
                'products' => [
                    ['name' => 'Basreng Ceroxand Pcs', 'price' => 1500, 'description' => '1 bungkus mini renyah gurih pedas.'],
                    ['name' => 'Paket Murah Basreng 4 Pcs', 'price' => 5000, 'description' => 'Paket hemat 4 pcs basreng untuk teman nugas.'],
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
