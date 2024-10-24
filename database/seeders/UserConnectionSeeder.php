<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserConnection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::where('is_admin', false)->each(function ($user) {
            $connectedUser = User::where('id', '!=', $user->id)->where('is_admin', false)->inRandomOrder()->first();

            if ($connectedUser) {
                UserConnection::factory()->create([
                    'user_id' => $user->id,
                    'connected_user_id' => $connectedUser->id,
                ]);

                UserConnection::factory()->create([
                    'user_id' => $connectedUser->id,
                    'connected_user_id' => $user->id,
                ]);
            }
        });
    }
}
