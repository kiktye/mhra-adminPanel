<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['photo_path', 'title', 'description', 'sections', 'user_id', 'is_featured'];

    protected $casts = [
        'sections' => 'array',
    ];

    // A blog can belong to specific User  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function relatedBlogs()
    {
        return Blog::where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%{$this->title}%")
                    ->orWhere('description', 'LIKE', "%{$this->description}%");
            })
            ->limit(4)
            ->get();
    }
}
