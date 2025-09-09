<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BarangMasuk;
use App\Models\StokBarang;
use Illuminate\Support\Facades\DB;

class SyncStokBarang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stok:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync stock data from barang_masuk to stok_barangs table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting stock synchronization...');
        
        // Clear existing stock data
        StokBarang::truncate();
        
        // Get aggregated stock from barang_masuk
        $stockData = BarangMasuk::selectRaw('nama_barang, satuan, SUM(qty) as total_qty')
            ->groupBy('nama_barang', 'satuan')
            ->havingRaw('SUM(qty) > 0')
            ->get();
            
        $count = 0;
        foreach ($stockData as $item) {
            StokBarang::create([
                'nama_barang' => $item->nama_barang,
                'satuan' => $item->satuan,
                'qty' => $item->total_qty
            ]);
            $count++;
        }
        
        $this->info("Stock synchronization completed. {$count} items synced.");
        
        return 0;
    }
}
