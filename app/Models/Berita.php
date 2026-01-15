<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    // Tidak perlu $table karena Laravel otomatis plural 'Berita' -> 'beritas'
    // Tapi untuk eksplisit, bisa tambahkan:
    protected $table = 'beritas';
    
    protected $fillable = ['title', 'slug', 'content', 'image'];
    
    // Optional: Auto generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $slug = Str::slug($berita->title);
                $count = Berita::where('slug', 'like', "$slug%")->count();
                
                if ($count > 0) {
                    $berita->slug = $slug . '-' . ($count + 1);
                } else {
                    $berita->slug = $slug;
                }
            }
        });
    }
}