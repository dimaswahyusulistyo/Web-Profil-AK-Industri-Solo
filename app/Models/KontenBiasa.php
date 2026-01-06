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
        'embeds',
        'form_id',
        'buttons'
    ];

    protected $casts = [
        'embeds' => 'array',
        'buttons' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'page_id');
    }
}