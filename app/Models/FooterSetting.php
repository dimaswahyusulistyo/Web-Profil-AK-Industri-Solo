<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'logo',
        'description',
        'phone',
        'email',
        'address',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'quick_links',
        'related_links',
        'copyright',
    ];

    protected $casts = [
        'quick_links' => 'array',
        'related_links' => 'array',
    ];
}
