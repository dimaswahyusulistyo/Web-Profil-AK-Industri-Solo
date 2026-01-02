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
        'no_telp',
        'kategori_aduan_id',
        'pesan',
        'data_dukung',
        'tanggapan'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAduan::class, 'kategori_aduan_id');
    }
}