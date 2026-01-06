<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    
    protected $fillable = [
        'nama_kategori',
        'url_halaman'
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}