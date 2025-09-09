<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_barang',
        'qty',
        'satuan',
        'harga_jual',
        'total_penjualan',
        'laba',
        'stok_awal',
        'stok_akhir',
        'dokumentasi',
        'dokumen_public_id'
    ];

    // Add accessor to map 'dokumen' to 'dokumentasi' for backward compatibility
    public function getDokumenAttribute()
    {
        return $this->dokumentasi;
    }

    // Add mutator to map 'dokumen' to 'dokumentasi' for backward compatibility
    public function setDokumenAttribute($value)
    {
        $this->attributes['dokumentasi'] = $value;
    }

    protected $casts = [
        'tanggal' => 'date',
        'qty' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'total_penjualan' => 'decimal:2',
        'laba' => 'decimal:2',
        'stok_awal' => 'decimal:2',
        'stok_akhir' => 'decimal:2'
    ];
}
