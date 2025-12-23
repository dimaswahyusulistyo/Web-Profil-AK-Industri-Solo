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
        'konten'
    ];

    // Relasi ke komentar
    public function komentar()
    {
        return $this->morphMany(Komentar::class, 'commentable');
    }
}