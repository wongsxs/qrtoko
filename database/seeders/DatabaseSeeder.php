<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kopi = Store::updateOrCreate(
            ['slug' => 'kopi-titik-temu'],
            [
                'name' => 'Kopi Titik Temu',
                'tagline' => 'Racikan Biji Kopi Pilihan & Tempat Singgah Ternyaman',
                'description' => 'Kedai kopi santai di sudut kota. Menyajikan seduhan kopi arabika nusantara, pastry renyah, dan minuman non-kopi menyegarkan. Menerima pesanan dine-in & takeaway.',
                'announcement' => 'Promo Spesial: Beli 2 Kopi Susu Aren Gratis 1 Donat Gula!',
                'facilities' => [
                    'Menerima QRIS',
                    'Free WiFi',
                    'Parkir Kendaraan',
                    'Bisa Kirim / Delivery',
                    'Ruangan Ber-AC',
                    'Colokan Listrik',
                ],
                'phone' => '081234567890',
                'address' => 'Jl. Pandanaran No. 45, Kota Malang, Jawa Timur',
                'maps_url' => 'https://maps.google.com/?q=Kota+Malang',
                'instagram' => '@kopititiktemu.id',
                'opening_hours' => 'Setiap Hari: 08.00 - 23.00 WIB',
                'is_open' => true,
                'category' => 'Kafe & Kopi',
                'theme_color' => '#059669',
            ]
        );

        if ($kopi->products()->count() === 0) {
            $kopi->products()->createMany([
                [
                    'name' => 'Kopi Susu Gula Aren Spesial',
                    'category' => 'Coffee',
                    'price' => 18000,
                    'description' => 'Espresso ganda, susu segar creamy, dan gula aren organik murni.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Iced Americano Single Origin',
                    'category' => 'Coffee',
                    'price' => 15000,
                    'description' => 'Ekstraksi biji kopi arabika lokal dengan aroma floral dan citrus menyegarkan.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Creamy Kyoto Matcha Latte',
                    'category' => 'Non-Coffee',
                    'price' => 22000,
                    'description' => 'Bubuk matcha murni dipadu susu segar lembut dengan manis pas.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Artisan Butter Croissant',
                    'category' => 'Pastry & Camilan',
                    'price' => 20000,
                    'description' => 'Roti pastry Prancis renyah di luar, lembut berlapis di dalam dengan French butter.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Kentang Goreng Truffle Cheese',
                    'category' => 'Pastry & Camilan',
                    'price' => 18000,
                    'description' => 'Kentang gurih renyah dengan taburan keju parmesan dan aroma minyak truffle.',
                    'is_available' => true,
                ],
            ]);
        }

        $barber = Store::updateOrCreate(
            ['slug' => 'barber-bro-klasik'],
            [
                'name' => 'Barber Bro Klasik',
                'tagline' => 'Potong Rambut Presisi & Grooming Pria Berkelas',
                'description' => 'Barbershop modern dengan sentuhan pelayanan hangat. Melayani potong rambut, cukur jenggot, pewarnaan rambut, dan perawatan relaksasi kepala.',
                'announcement' => 'Khusus hari Jumat istirahat jam 11.30 - 13.00 WIB untuk Ibadah Sholat Jumat.',
                'facilities' => [
                    'Menerima QRIS',
                    'Ruangan Ber-AC',
                    'Free WiFi',
                    'Parkir Kendaraan',
                ],
                'phone' => '087788991122',
                'address' => 'Jl. Soekarno Hatta No. 88, Kota Malang',
                'maps_url' => 'https://maps.google.com/?q=Soekarno+Hatta+Malang',
                'instagram' => '@barberbro.mlg',
                'opening_hours' => 'Selasa - Minggu: 10.00 - 21.00 WIB (Senin Tutup)',
                'is_open' => true,
                'category' => 'Jasa & Grooming',
                'theme_color' => '#0284c7',
            ]
        );

        if ($barber->products()->count() === 0) {
            $barber->products()->createMany([
                [
                    'name' => 'Gentleman Haircut & Styling',
                    'category' => 'Potong Rambut',
                    'price' => 45000,
                    'description' => 'Konsultasi gaya rambut, potong presisi, cuci rambut wangi, dan styling pomade.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Beard Trim & Hot Towel Shave',
                    'category' => 'Cukur & Grooming',
                    'price' => 25000,
                    'description' => 'Rapikan kumis & jenggot dengan handuk hangat aromaterapi.',
                    'is_available' => true,
                ],
                [
                    'name' => 'Hair Tonic Massage & Relaksasi',
                    'category' => 'Perawatan',
                    'price' => 30000,
                    'description' => 'Pijat relaksasi kepala dan pundak dengan tonic penyegar akar rambut.',
                    'is_available' => true,
                ],
            ]);
        }
    }
}
