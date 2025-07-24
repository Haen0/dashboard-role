<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'nama_dokumen',
        'jenis_dokumen',
        'file_path'
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }
}
