<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PenjualanMaggot extends Model
{
    protected $table = 'penjualans_maggot';

    protected $fillable = [
        'no',
        'tanggal',
        'produk',
        'qty',
        'harga',
        'total'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga' => 'decimal:2',
        'total' => 'decimal:2'
    ];
}
