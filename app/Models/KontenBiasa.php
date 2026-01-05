<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontenBiasa extends Model
{
    use HasFactory;

    protected $table = 'konten_biasa';
    
    protected $fillable = [
        'judul',
        'url_halaman',
        'konten',
        'embed_url',
        'form_id',
        'button_text',
        'button_url'
    ];

    // Relasi ke form dinamis
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    // Relasi ke menu
    public function menus()
    {
        return $this->hasMany(Menu::class, 'page_id');
    }
}