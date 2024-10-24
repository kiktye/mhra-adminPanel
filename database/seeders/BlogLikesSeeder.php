<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogLike;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::all()->each(function ($blog) {
            $users = User::all()->random(2); 
            
            foreach ($users as $user) {
                BlogLike::create([
                    'blog_id' => $blog->id,
                    'user_id' => $user->id,
                ]);
            }
        });
    }
}
