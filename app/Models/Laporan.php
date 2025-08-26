<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_dari',
        'tanggal_ke',
        'jumlah_kasus',
        'jumlah_konsultasi',
        'catatan_manajer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
