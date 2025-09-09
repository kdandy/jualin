<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $fillable = [
        'nama_barang',
        'qty',
        'satuan'
    ];

    protected $casts = [
        'qty' => 'decimal:2'
    ];
}
