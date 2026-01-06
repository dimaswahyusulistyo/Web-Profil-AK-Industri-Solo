<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    
    protected $fillable = [
        'nama',
        'email',
        'isi_komentar',
        'commentable_type',
        'commentable_id',
        'parent_id',
        'tanggapan',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }
}