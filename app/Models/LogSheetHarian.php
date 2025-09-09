<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSheetHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'media',
        'suhu',
        'kelembapan',
        'berat_limbah',
        'fase_kehidupan',
        'jenis_sampah',
        'berat_kasgot',
        'dokumentasi',
        'dokumentasi_public_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'suhu' => 'decimal:2',
        'kelembapan' => 'decimal:2',
        'berat_limbah' => 'decimal:2',
        'berat_kasgot' => 'decimal:2'
    ];

    /**
     * Daftar fase kehidupan metamorfosis lalat BSF
     */
    public static function getFaseKehidupan()
    {
        return [
            'Telur' => 'Telur',
            'Larva Instar 1' => 'Larva Instar 1',
            'Larva Instar 2' => 'Larva Instar 2',
            'Larva Instar 3' => 'Larva Instar 3',
            'Larva Instar 4' => 'Larva Instar 4',
            'Larva Instar 5' => 'Larva Instar 5',
            'Larva Instar 6' => 'Larva Instar 6',
            'Prepupa' => 'Prepupa',
            'Pupa' => 'Pupa',
            'Dewasa' => 'Dewasa'
        ];
    }
}