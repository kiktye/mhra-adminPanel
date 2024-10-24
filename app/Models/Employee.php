<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'title',
        'description',
        'social_links',
        'photo_path',
        'role_id',
    ];

    protected $casts = [
        'social_links' => 'array',
        'description' => 'array',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
