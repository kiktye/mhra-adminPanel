<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::all()->each(function ($event) {
            Speaker::factory()->count(3)->create([
                'event_id' => $event->id
            ]);
        });

        Conference::all()->each(function ($conference) {
            Speaker::factory()->count(3)->create([
                'conference_id' => $conference->id
            ]);
        });

        Conference::all()->each(function ($conference) {
            Speaker::factory()->count(3)->create([
                'conference_id' => $conference->id,
                'is_special_guest' => true
            ]);
        });
    }
}
