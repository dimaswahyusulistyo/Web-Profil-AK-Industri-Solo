<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'category_id',
        'konten',
        'thumbnail',
        'tanggal_publikasi',
        'is_active',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'is_active'         => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
