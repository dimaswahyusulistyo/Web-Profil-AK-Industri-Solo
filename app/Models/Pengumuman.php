<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    
    protected $fillable = [
        'judul',
        'url_halaman',
        'thumbnail',
        'konten',
        'buttons',
        'created_at'
    ];

    protected $casts = [
        'buttons' => 'array',
    ];

    public function komentar()
    {
        return $this->morphMany(Komentar::class, 'commentable');
    }
}