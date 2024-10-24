<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'photo_path',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
