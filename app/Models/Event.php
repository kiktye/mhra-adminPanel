<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'theme',
        'description',
        'objective',
        'location',
        'date',
        'ticket_prices',
        'agenda_id',
        'is_featured',
        'photo_path',
    ];

    protected $casts = [
        'ticket_prices' => 'array',
    ];

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function relatedEvents()
    {
        return Event::where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%{$this->title}%")
                    ->orWhere('description', 'LIKE', "%{$this->description}%");
            })
            ->limit(4)
            ->get();
    }
}
