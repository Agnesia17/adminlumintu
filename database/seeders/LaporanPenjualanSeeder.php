<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LaporanPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $data[] = [
                'tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'nama_pembeli' => 'Pembeli ' . ($i + 1),
                'nama_produk' => 'CPO',
                'harga_jual' => rand(10000, 50000),
                'jumlah' => rand(1, 10),
                'total' => rand(100000, 500000),
                'id_product' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        for ($i = 0; $i < 15; $i++) {
            $data[] = [
                'tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'nama_pembeli' => 'Pembeli ' . ($i + 16),
                'nama_produk' => 'Jelantah Pak Tabrani',
                'harga_jual' => rand(5000, 30000),
                'jumlah' => rand(1, 10),
                'total' => rand(50000, 300000),
                'id_product' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('laporan_penjualan')->insert($data);
    }
}
