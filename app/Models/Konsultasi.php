<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'klien_id',
        'advokat_id',
        'tanggal',
        'jenis_kasus',
        'ringkasan',
        'status',
    ];

    public function klien()
    {
        return $this->belongsTo(Klient::class);
    }

    public function advokat()
    {
        return $this->belongsTo(Advokat::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

}
