<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klient extends Model
{
    use HasFactory;

    protected $table = 'klients';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
    ];
}
