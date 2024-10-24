<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Conference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = Agenda::whereJsonLength('days', '>', 1)->get();

        foreach ($agendas as $agenda) {
            Conference::factory()->create([
                'agenda_id' => $agenda->id
            ]);
        }
    }
}
