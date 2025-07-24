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
        'dokumen'
    ];

    public function klien()
    {
        return $this->belongsTo(Klient::class);
    }

    public function advokat()
    {
        return $this->belongsTo(Advokat::class);
    }
}
