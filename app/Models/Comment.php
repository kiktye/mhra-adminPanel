<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['content', 'user_id', 'blog_id', 'parent_id', 'likes'];

    protected $attributes = [
        'likes' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->withTrashed();
    }


    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'comment_user_likes', 'comment_id', 'user_id');
    }

    public function isLikedBy(User $user)
    {
        return $this->likedByUsers()->where('user_id', $user->id)->exists();
    }
}
