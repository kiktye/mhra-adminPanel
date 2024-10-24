<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $connectedUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'connected_user_id' => $connectedUser->id,
            'status' => 'accepted',
        ];
    }
}
