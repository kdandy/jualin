<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tanggal',
        'pemasok',
        'nama_barang',
        'qty',
        'satuan',
        'harga_beli',
        'total_pembelian',
        'dokumentasi',
        'dokumentasi_public_id'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'qty' => 'decimal:2',
        'harga_beli' => 'decimal:2',
        'total_pembelian' => 'decimal:2'
    ];
}
