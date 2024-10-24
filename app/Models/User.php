<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'phone',
        'city',
        'country',
        'title',
        'bio',
        'cv_path',
        'photo_path',
        'restricted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function likedBlogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_likes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user_likes')->withTimestamps();
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'user_connections', 'user_id', 'connected_user_id');
    }

    public function receivedRecommendations()
    {
        return $this->hasMany(Recommendation::class, 'receiver_id');
    }

    public function sentRecommendations()
    {
        return $this->hasMany(Recommendation::class, 'sender_id');
    }

}
