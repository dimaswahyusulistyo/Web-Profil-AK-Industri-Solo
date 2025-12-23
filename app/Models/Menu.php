<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';

    protected $fillable = [
        'nama_menu', 'parent_id', 'link_type', 'page_id', 'url_halaman', 'urutan'
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo(KontenBiasa::class, 'page_id');
    }
}
