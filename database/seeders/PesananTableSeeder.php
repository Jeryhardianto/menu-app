<?php

namespace Database\Seeders;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        mt_srand(2024); // data contoh tetap sama tiap kali di-seed

        $menus = Menu::all();
        $pelanggan = User::where('role', 'Pelanggan')->pluck('id')->all();
        $kasir = User::where('role', 'Kasir')->value('id');

        if ($menus->isEmpty() || empty($pelanggan) || ! $kasir) {
            $this->command->warn('MenusTableSeeder & UsersTableSeeder harus jalan lebih dulu.');
            return;
        }

        // 1 = PENDING, 2 = IN PROGRESS, 4 = CANCEL, 6 = COMPLETED
        $statuses = [6, 6, 6, 6, 6, 2, 1, 4];
        $metodes = ['cash', 'qris', 'tf'];
        $types = ['Dine In', 'Take Away'];

        foreach (range(0, 23) as $i) {
            $waktu = strtotime(sprintf('-%d days %d:%02d:00', intdiv($i, 2), mt_rand(8, 20), mt_rand(0, 59)));
            $status = $statuses[$i % count($statuses)];
            $metode = $metodes[$i % count($metodes)];
            $type = $types[$i % count($types)];

            $pesanan = Pesanan::create([
                'id_user' => $pelanggan[$i % count($pelanggan)],
                'kasir' => $kasir,
                'no_transaksi' => 'TRX-' . $waktu,
                'nomor_meja' => $type === 'Dine In' ? mt_rand(1, 10) : 0,
                'tanggal' => date('Y-m-d', $waktu),
                'waktu' => date('H:i:s', $waktu),
                'id_status' => $status,
                'type' => $type,
                'total' => 0,
                'bukti_bayar' => $metode === 'cash' ? 'cash' : null,
                'metode_pembayaran' => $metode,
                'catatan_kasir' => null,
                'created_at' => date('Y-m-d H:i:s', $waktu),
                'updated_at' => date('Y-m-d H:i:s', $waktu),
            ]);

            $total = 0;

            foreach ($menus->random(mt_rand(1, 3)) as $menu) {
                $jumlah = mt_rand(1, 3);
                $subtotal = $menu->harga * $jumlah;
                $total += $subtotal;

                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'id_menu' => $menu->id,
                    'jumlah' => $jumlah,
                    'harga' => $menu->harga,
                    'subtotal' => $subtotal,
                    'deskripsi' => null,
                    'created_at' => date('Y-m-d H:i:s', $waktu),
                    'updated_at' => date('Y-m-d H:i:s', $waktu),
                ]);

                // pesanan selesai ikut menambah angka terjual, sama seperti di Order controller
                if ($status == 6) {
                    $menu->increment('terjual', $jumlah);
                }
            }

            $pesanan->update(['total' => $total]);
        }
    }
}
