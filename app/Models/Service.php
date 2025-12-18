<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'nama_layanan',
        'ikon',
        'tautan',
        'urutan',
        'tampil_di_home',
        'is_active',
    ];

    protected $casts = [
        'tampil_di_home' => 'boolean',
        'is_active'      => 'boolean',
    ];
}
