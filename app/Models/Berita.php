<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $fillable = [
        'judul',
        'url_halaman',
        'kategori_id',
        'konten',
        'thumbnail'
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    // Relasi ke komentar
    public function komentar()
    {
        return $this->morphMany(Komentar::class, 'commentable');
    }
}