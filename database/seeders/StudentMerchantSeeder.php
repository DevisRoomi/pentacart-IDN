<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Database\Seeder;

class StudentMerchantSeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::listings() as $data) {
            $merchant = Merchant::firstOrNew(['slug' => $data['slug']]);

            if ($merchant->exists && $merchant->user_id !== null) {
                continue;
            }

            $merchant->fill([
                'user_id' => null,
                'name' => $data['shop_name'],
                'phone' => $data['phone'],
                'qris_image' => 'https://drive.google.com/uc?export=view&id='.$data['qris_drive_id'],
                'location' => $data['location'],
                'description' => $data['description'],
                'keywords' => $data['keywords'],
                'is_open' => true,
                'schedule' => $data['schedule'],
            ]);
            $merchant->save();

            foreach ($data['products'] as $product) {
                Product::updateOrCreate(
                    [
                        'merchant_id' => $merchant->id,
                        'name' => $product['name'],
                    ],
                    [
                        'price' => $product['price'],
                        'description' => $product['description'],
                        'is_available' => true,
                    ]
                );
            }
        }
    }

    public static function listings(): array
    {
        return [
            [
                'phone' => '6281455147800',
                'shop_name' => 'Gorio Rio',
                'slug' => 'gorio-rio-asrama',
                'location' => 'Kamar 2',
                'description' => 'Minuman es gorio rio. Harga belum dicantumkan; hubungi penjual untuk harga.',
                'keywords' => 'Minuman & Es, gorio rio, es blender, kamar 2',
                'schedule' => [
                    ['start' => '12:00', 'end' => '15:30'],
                ],
                'qris_drive_id' => '1AFW1_x3aWlt4157r8dZ_ueps137DnuVG',
                'products' => [],
            ],
            [
                'phone' => '6281412135854',
                'shop_name' => 'Junk Food',
                'slug' => 'zaky-junk-food',
                'location' => 'Asrama',
                'description' => 'Junk food.',
                'keywords' => 'Snack & Cemilan, fast food, gorengan',
                'schedule' => [
                    ['start' => '11:30', 'end' => '13:00'],
                    ['start' => '16:00', 'end' => '17:30'],
                ],
                'qris_drive_id' => '1vXYufmqMQ_zcn0ndjtrABizVbiUak5Ix',
                'products' => [
                    ['name' => 'Junk Food', 'price' => 12000, 'description' => null],
                ],
            ],
            [
                'phone' => '6282288705542',
                'shop_name' => 'Mie',
                'slug' => 'mie-arya-asrama',
                'location' => 'Asrama',
                'description' => 'Mie instan dan jasa masak ba\'da maghrib sampai 21.00. Pesan mie kuah usahakan bawa mangkok sendiri.',
                'keywords' => 'Makanan Berat, mie, jasa masak, asrama',
                'schedule' => [
                    ['start' => '18:15', 'end' => '21:00'],
                ],
                'qris_drive_id' => '1Xwxp7IGOLyhIzoa7WbV-CyFXQthBnm0I',
                'products' => [
                    ['name' => '1 Mie', 'price' => 6000, 'description' => null],
                    ['name' => '2 Mie', 'price' => 10000, 'description' => null],
                    ['name' => 'Jasa Masak', 'price' => 2000, 'description' => null],
                ],
            ],
            [
                'phone' => '6282298791015',
                'shop_name' => 'Basreng, Usus, Kacang',
                'slug' => 'basreng-usus-kacang',
                'location' => 'Kamar Asrama',
                'description' => 'Siap antar sekitar Politeknik IDN.',
                'keywords' => 'Snack & Cemilan, basreng, usus, kacang',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_drive_id' => '1ZtPF85dN8C6d9MBIFCfbcd1EHCEFUa1t',
                'products' => [
                    ['name' => 'Basreng (3 pcs)', 'price' => 5000, 'description' => null],
                    ['name' => 'Usus (2 pcs)', 'price' => 5000, 'description' => null],
                    ['name' => 'Kacang (3 pcs)', 'price' => 5000, 'description' => null],
                ],
            ],
            [
                'phone' => '6282120856921',
                'shop_name' => 'Aqeepstore',
                'slug' => 'aqeepstore',
                'location' => 'Kamar Asrama',
                'description' => 'Moring pedas & asin.',
                'keywords' => 'Snack & Cemilan, moring, pedas, asin',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_drive_id' => '19Q0UIizTBzn0jHH6kuE2gKwQt3aYsX2O',
                'products' => [
                    ['name' => 'Moring Pedas & Asin', 'price' => 2000, 'description' => null],
                ],
            ],
            [
                'phone' => '6282289224094',
                'shop_name' => 'Kripik Pisang Krispy',
                'slug' => 'kripik-pisang-krispy',
                'location' => 'Asrama 4',
                'description' => 'Jasa antar lingkungan IDN.',
                'keywords' => 'Snack & Cemilan, keripik pisang, coklat, vanilla, greentea, asrama 4',
                'schedule' => [
                    ['start' => '07:00', 'end' => '23:00'],
                ],
                'qris_drive_id' => '1eQNHkC6eqYduYF_uMaizPdEdAw0htj7J',
                'products' => [
                    ['name' => 'Keripik Pisang Rasa Coklat', 'price' => 2500, 'description' => null],
                    ['name' => 'Keripik Pisang Rasa Vanilla', 'price' => 2500, 'description' => null],
                    ['name' => 'Keripik Pisang Rasa Greentea', 'price' => 2500, 'description' => null],
                ],
            ],
            [
                'phone' => '6285814965129',
                'shop_name' => 'Roti AOKA',
                'slug' => 'roti-aoka',
                'location' => 'Asrama 2',
                'description' => 'Roti AOKA siap santap.',
                'keywords' => 'Snack & Cemilan, roti aoka, asrama 2',
                'schedule' => [
                    ['start' => '06:00', 'end' => '23:00'],
                ],
                'qris_drive_id' => '1MdzHdRPpH-yic39TiOcwf9HhATP5nDww',
                'products' => [
                    ['name' => 'Roti AOKA', 'price' => 3000, 'description' => null],
                ],
            ],
            [
                'phone' => '6289541139369',
                'shop_name' => 'Ubilum',
                'slug' => 'ubilum',
                'location' => 'Kos',
                'description' => 'Ubilum. Harga belum dicantumkan; hubungi penjual untuk harga.',
                'keywords' => 'Snack & Cemilan, ubilum, kos',
                'schedule' => [
                    ['start' => '08:00', 'end' => '22:00'],
                ],
                'qris_drive_id' => '1bi6jixcnvrp3PaePPqItxneaAbDzbZDg',
                'products' => [],
            ],
            [
                'phone' => '6285719496404',
                'shop_name' => 'Cordog',
                'slug' => 'cordog',
                'location' => 'Sakan 1',
                'description' => 'Cordog. Harga belum dicantumkan; hubungi penjual untuk harga.',
                'keywords' => 'Snack & Cemilan, cordog, sakan 1',
                'schedule' => [
                    ['start' => '16:00', 'end' => '22:00'],
                ],
                'qris_drive_id' => '1her8qn44NwXfWbXs4McWuIrJZpfSrX0s',
                'products' => [],
            ],
            [
                'phone' => '6285157166459',
                'shop_name' => 'Ceroxand Crisp Co.',
                'slug' => 'ceroxand-crisp-co',
                'location' => 'Saung 1',
                'description' => 'Basreng Ceroxand.',
                'keywords' => 'Snack & Cemilan, basreng, saung 1',
                'schedule' => [
                    ['start' => '08:00', 'end' => '23:00'],
                ],
                'qris_drive_id' => '1u2OvFV--xEiTRPM0RXtRUZTyIHG1YUkl',
                'products' => [
                    ['name' => 'Basreng (1 pcs)', 'price' => 1500, 'description' => null],
                    ['name' => 'Paket Murah Basreng (4 pcs)', 'price' => 5000, 'description' => null],
                ],
            ],
        ];
    }
}
