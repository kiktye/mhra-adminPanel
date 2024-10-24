<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'days'];

    protected $casts = [
        'days' => 'array',
    ];


    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function conference()
    {
        return $this->hasOne(Conference::class);
    }
}
