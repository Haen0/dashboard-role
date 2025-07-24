<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'tanggal',
        'waktu',
        'lokasi',
        'selesai'
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }
}
