<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AspirasiAduan extends Model
{
    use HasFactory;

    protected $table = 'aspirasi_aduan';
    
    protected $fillable = [
        'nama',
        'email',
        'pesan',
        'tanggapan'
    ];
}