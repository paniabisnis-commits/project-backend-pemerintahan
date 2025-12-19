<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans'; // atau 'layanan' SESUAI DB

    protected $fillable = [
        'kategori',
        'nama_layanan',
        'deskripsi',
        'gambar'
    ];
}
