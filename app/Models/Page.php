<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'layout',
        'konten',
        'konfigurasi',
        'is_active',
    ];

    protected $casts = [
        'konfigurasi' => 'array',
        'is_active'   => 'boolean',
    ];
}
