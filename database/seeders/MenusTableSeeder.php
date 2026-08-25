<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * 100 makanan + 100 minuman. Gambar pakai picsum.photos (gratis, tanpa API key),
     * seed diambil dari nama menu supaya fotonya tetap sama tiap reload.
     *
     * @return void
     */
    public function run()
    {
        mt_srand(2024); // harga contoh tetap sama tiap kali di-seed

        $rows = [];

        foreach ($this->groups() as $group) {
            foreach ($group['menus'] as $nama) {
                $rows[] = [
                    'id_subkategori' => $group['id_subkategori'],
                    'nama_menu' => $nama,
                    'harga' => mt_rand($group['harga'][0] / 500, $group['harga'][1] / 500) * 500,
                    'deskripsi' => $nama . ' ' . $group['deskripsi'],
                    'gambar' => 'https://picsum.photos/seed/' . Str::slug($nama) . '/400/300',
                    'stok' => 25,
                    'terjual' => 0,
                    'is_available' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('menus')->insert($rows);
    }

    /**
     * id_subkategori: 1 Best Seller Minuman, 2 Nasi, 3 Indomie, 4 Cemilan,
     *                 5 Non Kopi, 6 Kopi, 7 Tea, 8 Kemasan
     */
    private function groups(): array
    {
        return [
            [
                'id_subkategori' => 2,
                'harga' => [18000, 35000],
                'deskripsi' => 'disajikan hangat dengan sambal dan lalapan.',
                'menus' => [
                    'Nasi Goreng Spesial', 'Nasi Goreng Kampung', 'Nasi Goreng Seafood', 'Nasi Goreng Petai',
                    'Nasi Goreng Sosis', 'Nasi Goreng Rendang', 'Nasi Goreng Kambing', 'Nasi Ayam Geprek',
                    'Nasi Ayam Penyet', 'Nasi Ayam Bakar Madu', 'Nasi Ayam Rica-Rica', 'Nasi Ayam Katsu',
                    'Nasi Ayam Teriyaki', 'Nasi Ayam Kremes', 'Nasi Bebek Goreng', 'Nasi Bebek Sambal Ijo',
                    'Nasi Rendang Daging', 'Nasi Empal Gepuk', 'Nasi Dendeng Balado', 'Nasi Iga Bakar',
                    'Nasi Sapi Lada Hitam', 'Nasi Telur Dadar', 'Nasi Uduk Komplit', 'Nasi Kuning Komplit',
                    'Nasi Liwet Sunda', 'Nasi Timbel Komplit', 'Nasi Pecel Madiun', 'Nasi Rawon Daging',
                    'Nasi Soto Ayam', 'Nasi Gudeg Jogja', 'Nasi Bakar Ayam Suwir', 'Nasi Bakar Teri Kemangi',
                    'Nasi Campur Bali', 'Nasi Lemak Ayam', 'Nasi Cumi Hitam', 'Nasi Udang Balado',
                    'Nasi Tongkol Suwir', 'Nasi Lele Goreng', 'Nasi Nila Bakar', 'Nasi Tahu Tempe Penyet',
                ],
            ],
            [
                'id_subkategori' => 3,
                'harga' => [12000, 22000],
                'deskripsi' => 'dimasak dadakan, cocok untuk makan malam.',
                'menus' => [
                    'Indomie Goreng Original', 'Indomie Goreng Telur', 'Indomie Goreng Kornet',
                    'Indomie Goreng Keju', 'Indomie Goreng Ayam Suwir', 'Indomie Goreng Seafood',
                    'Indomie Goreng Sosis Telur', 'Indomie Goreng Rendang', 'Indomie Goreng Pedas Mercon',
                    'Indomie Goreng Jumbo', 'Indomie Rebus Original', 'Indomie Rebus Telur',
                    'Indomie Rebus Kornet', 'Indomie Rebus Ayam Bawang', 'Indomie Rebus Soto',
                    'Indomie Rebus Kari Ayam', 'Indomie Rebus Sayur Sawi', 'Indomie Rebus Bakso',
                    'Indomie Kuah Seblak', 'Indomie Nyemek Telur', 'Indomie Carbonara', 'Indomie Tom Yam',
                    'Indomie Aceh Pedas', 'Indomie Tteokbokki', 'Indomie Salted Egg',
                ],
            ],
            [
                'id_subkategori' => 4,
                'harga' => [10000, 25000],
                'deskripsi' => 'digoreng fresh, pas untuk teman ngobrol.',
                'menus' => [
                    'Kentang Goreng', 'Kentang Goreng Keju', 'Kentang Spiral', 'Sosis Bakar',
                    'Sosis Goreng Saus BBQ', 'Nugget Ayam', 'Chicken Wing Honey', 'Chicken Wing Spicy',
                    'Chicken Popcorn', 'Tahu Crispy', 'Tahu Cabe Garam', 'Tempe Mendoan', 'Bakwan Jagung',
                    'Pisang Goreng Keju', 'Pisang Nugget Coklat', 'Roti Bakar Coklat Keju',
                    'Roti Bakar Srikaya', 'Singkong Goreng', 'Cireng Bumbu Rujak', 'Cilok Kuah', 'Batagor',
                    'Siomay Bandung', 'Dimsum Ayam', 'Lumpia Sayur', 'Risoles Mayo', 'Martabak Mini Coklat',
                    'Onion Ring', 'Jamur Crispy', 'Udang Rambutan', 'Otak-Otak Goreng', 'Corndog Mozarella',
                    'Takoyaki', 'Churros Coklat', 'Donat Gula', 'Kue Cubit',
                ],
            ],
            [
                'id_subkategori' => 1,
                'harga' => [18000, 28000],
                'deskripsi' => 'favorit pelanggan, selalu habis duluan.',
                'menus' => [
                    'Es Kopi Susu Gula Aren', 'Es Teh Manis Jumbo', 'Es Jeruk Peras', 'Es Cokelat Premium',
                    'Matcha Latte Ice', 'Es Kopi Pandan', 'Thai Tea Original', 'Es Susu Kurma',
                    'Lemon Tea Ice', 'Es Milo Dinosaurus',
                ],
            ],
            [
                'id_subkategori' => 6,
                'harga' => [15000, 32000],
                'deskripsi' => 'diseduh dari biji arabika pilihan.',
                'menus' => [
                    'Espresso Single', 'Espresso Double', 'Americano Hot', 'Americano Ice', 'Long Black',
                    'Cappuccino Hot', 'Cappuccino Ice', 'Cafe Latte Hot', 'Cafe Latte Ice', 'Flat White',
                    'Piccolo Latte', 'Macchiato', 'Mocha Hot', 'Mocha Ice', 'Kopi Susu Gula Aren',
                    'Kopi Susu Pandan', 'Kopi Susu Kelapa', 'Kopi Susu Hazelnut', 'Kopi Susu Caramel',
                    'Kopi Susu Vanilla', 'Kopi Tubruk', 'Kopi Tubruk Gula Batu', 'Kopi Vietnam Drip',
                    'Kopi Rum Manual Brew', 'V60 Gayo', 'V60 Toraja', 'Japanese Iced Coffee',
                    'Cold Brew Original', 'Cold Brew Orange', 'Affogato',
                ],
            ],
            [
                'id_subkategori' => 5,
                'harga' => [15000, 30000],
                'deskripsi' => 'segar tanpa kopi, bisa hot atau ice.',
                'menus' => [
                    'Cokelat Panas', 'Es Cokelat', 'Matcha Latte Hot', 'Matcha Latte Dingin',
                    'Red Velvet Latte', 'Taro Latte', 'Milkshake Vanilla', 'Milkshake Cokelat',
                    'Milkshake Stroberi', 'Milkshake Oreo', 'Jus Alpukat', 'Jus Mangga', 'Jus Jambu',
                    'Jus Stroberi', 'Jus Melon', 'Jus Semangka', 'Jus Wortel', 'Jus Tomat', 'Es Jeruk',
                    'Jeruk Hangat', 'Es Kelapa Muda', 'Es Campur', 'Es Teler', 'Es Cincau Susu', 'Es Doger',
                    'Susu Murni Hangat', 'Susu Kurma', 'Yakult Yuzu', 'Soda Gembira', 'Lemon Squash',
                ],
            ],
            [
                'id_subkategori' => 7,
                'harga' => [8000, 20000],
                'deskripsi' => 'diseduh dari daun teh pilihan.',
                'menus' => [
                    'Teh Tawar Hangat', 'Teh Manis Hangat', 'Es Teh Manis', 'Es Teh Tawar', 'Teh Tarik Hot',
                    'Teh Tarik Ice', 'Thai Tea Ice', 'Thai Tea Green', 'Lemon Tea Hot', 'Lemon Tea Dingin',
                    'Lychee Tea Ice', 'Peach Tea Ice', 'Apple Tea Ice', 'Teh Melati', 'Teh Hijau Hangat',
                    'Earl Grey Tea', 'Chamomile Tea', 'Teh Jahe Hangat', 'Teh Serai Madu', 'Teh Talua',
                ],
            ],
            [
                'id_subkategori' => 8,
                'harga' => [5000, 15000],
                'deskripsi' => 'siap minum, langsung ambil di kulkas.',
                'menus' => [
                    'Air Mineral 600ml', 'Air Mineral 1500ml', 'Teh Botol Kotak', 'Coca Cola Kaleng',
                    'Sprite Kaleng', 'Fanta Kaleng', 'Pocari Sweat', 'Ultra Milk Cokelat', 'Yakult 5 Botol',
                    'Kopi Kaleng Latte',
                ],
            ],
        ];
    }
}
