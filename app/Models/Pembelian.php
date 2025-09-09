<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembelian extends Model
{
    protected $fillable = [
        'no',
        'tanggal',
        'keterangan',
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
