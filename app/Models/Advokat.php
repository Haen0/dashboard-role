<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advokat extends Model
{
    use HasFactory;

    // kalau nama tabel Anda bukan "advokats", hilangkan komentar baris di bawah
    // protected $table = 'advokats';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'spesialis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
