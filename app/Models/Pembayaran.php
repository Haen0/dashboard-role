<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'tanggal',
        'jumlah',
        'metode',
        'status'
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }
}
