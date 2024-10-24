<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oneDayEventAgenda = Agenda::whereJsonLength('days', 1)->get();

        foreach ($oneDayEventAgenda as $agenda) {
            Event::factory()->create([
                'agenda_id' => $agenda->id
            ]);
        }
    }
}
