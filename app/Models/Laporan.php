<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Laporan.php
class Laporan extends Model
{
    protected $fillable = [
        'user_id', 'tipe', 'tanggal',
        'jumlah_kasus', 'jumlah_konsultasi', 'catatan_manajer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
