<?php

namespace Database\Seeders;

use App\Models\GeneralInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralInfo::factory()->count(1)->create();
    }
}
