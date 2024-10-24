<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::query()->create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@mhra.com',
            'password' => Hash::make('secret'),
            'is_admin' => true
        ]);

        Role::query()->create([
            'name' => 'Претседател на МАЧР'
        ]);

        $this->call([
            GeneralInfoSeeder::class,
            UserSeeder::class,
            AgendaSeeder::class,
            EventSeeder::class,
            ConferenceSeeder::class,
            SpeakerSeeder::class,
            EmployeeSeeder::class,
            BlogSeeder::class,
            CommentsSeeder::class,
            BlogLikesSeeder::class,
            UserConnectionSeeder::class,
            RecommendationSeeder::class
        ]);
    }
}
