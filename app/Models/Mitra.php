<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';
    
    protected $fillable = [
        'nama_mitra',
        'logo',
        'url',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer'
    ];
}