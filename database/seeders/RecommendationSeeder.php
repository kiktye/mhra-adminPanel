<?php

namespace Database\Seeders;

use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() > 2) {

            $users = User::where('is_admin', false)->get();

            Recommendation::factory()->count(10)->create()->each(function ($recommendation) use ($users) {
                $sender = $users->random();
                $receiver = $users->where('id', '!=', $sender->id)->random();

                $recommendation->update([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id
                ]);
            });
        }
    }
}
