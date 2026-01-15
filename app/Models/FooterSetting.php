<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'logo',
        'header_logo',
        'website_title',
        'favicon',
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
        'comments_enabled',
        'copyright',
    ];

    protected $casts = [
        'quick_links' => 'array',
        'related_links' => 'array',
        'comments_enabled' => 'boolean',
    ];
}
