<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'kategori',
        'nama_layanan',
        'deskripsi',
        'gambar',
    ];
}
