<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BarangMasuk;
use Carbon\Carbon;

class BarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tanggal' => Carbon::now()->subDays(5),
                'pemasok' => 'CV. Sampah Bersih',
                'nama_barang' => 'Botol Plastik',
                'qty' => 25.50,
                'satuan' => 'kg',
                'harga_beli' => 2000,
                'total_pembelian' => 25.50 * 2000,
                'dokumentasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(3),
                'pemasok' => 'PT. Daur Ulang Mandiri',
                'nama_barang' => 'Kardus Bekas',
                'qty' => 100,
                'satuan' => 'pcs',
                'harga_beli' => 1500,
                'total_pembelian' => 100 * 1500,
                'dokumentasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(2),
                'pemasok' => 'Toko Sampah Jaya',
                'nama_barang' => 'Kaleng Aluminium',
                'qty' => 15.75,
                'satuan' => 'kg',
                'harga_beli' => 8000,
                'total_pembelian' => 15.75 * 8000,
                'dokumentasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(1),
                'pemasok' => 'UD. Recycle Center',
                'nama_barang' => 'Kertas Koran',
                'qty' => 50.25,
                'satuan' => 'kg',
                'harga_beli' => 1200,
                'total_pembelian' => 50.25 * 1200,
                'dokumentasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => Carbon::now(),
                'pemasok' => 'CV. Green Waste',
                'nama_barang' => 'Gelas Plastik',
                'qty' => 200,
                'satuan' => 'pcs',
                'harga_beli' => 500,
                'total_pembelian' => 200 * 500,
                'dokumentasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($data as $item) {
            BarangMasuk::create($item);
        }
    }
}
