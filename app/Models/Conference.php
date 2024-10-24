<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conference extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'theme',
        'description',
        'location',
        'start_date',
        'end_date',
        'ticket_packages',
        'agenda_id',
        'status',
        'photo_path'
    ];

    protected $casts = [
        'ticket_packages' => 'array'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }
}
