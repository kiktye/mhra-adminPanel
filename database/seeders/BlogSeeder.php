<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::where('is_admin', false)->inRandomOrder()->first();

        if ($user) {
            Blog::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
