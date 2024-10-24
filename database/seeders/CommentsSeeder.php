<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $users = User::where('is_admin', false)->get();


        Blog::all()->each(function ($blog) use ($users) {
            $comments = Comment::factory()->count(5)->create([
                'blog_id' => $blog->id,
                'user_id' => $users->random()->id,
            ]);

            $comments->each(function ($comment) use ($users) {
                // comment replies
                Comment::factory()->count(2)->create([
                    'parent_id' => $comment->id,
                    'blog_id' => $comment->blog_id,
                    'user_id' => $users->random()->id,
                ]);
            });
        });
    }
}
