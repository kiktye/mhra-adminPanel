<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $casts = [
        'social_links' => 'array',
    ];

    protected $fillable = [
        'name',
        'surname',
        'title',
        'photo_path',
        'social_links',
        'event_id',
        'is_special_guest',
        'conference_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
