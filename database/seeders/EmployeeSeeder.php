<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $president = Role::where('name', 'Претседател на МАЧР')->first();

        $volunteer = Role::firstOrCreate(['name' => 'Волонтер']);

        $president = Employee::factory()->create(
            [
                'name' => 'Дарко',
                'surname' => 'Петровски',
                'title' => 'м-р Дарко Петровски',
                'role_id' => $president->id,
                'description' => json_encode([

                    '0' => 'Дарко е еден од основачите на МАЧР, каде придонесуваше како член на УО, претседател на Надзорниот одбор, генерален секретар и уредник на електронскиот весник на МАЧР, а на последното Собрание во декември 2018 беше избран за Претседател на Македонската асоцијација за човечки ресурси. Дарко помина речиси 9 годишен работен ангажман како раководител на одделот за човечки ресурси и организација во ЕВН, еден од најголемите работодавачи во Македонија. Пред тоа, тој беше на чело на Канцеларијата за економски прашања при Австриската амбасада во Скопје.',
                    '1' => 'Дарко е основач на Талент бизнис инкубаторот Степ-ап кој нуди програми за стипендирање и развој на таленти, за практикантска работа и консултантски услуги во областа на стратегиски деловен развој, организациски развој и менаџмент со човечките ресурси. Тој е и ко-основач и партнер во Динамик Консалтинг и е вклучен во проекти како менаџмент консултант во различни области.',
                    '2' => 'Покрај професионалниот ангажман, Дарко бил и е сеуште активен во повеќе организации како Организацијата на работодавачи на Македонија, Националниот економско-социјален совет, Локалниот економско-социјален совет на град Скопје, Техничкиот комитет за менаџмент со човечките ресурси (ТК42) при Институтот за стандардизација на РМ, Националниот совет за претприемништво и конкурентност, советодавните одбори на Универзитетот за туризам и менаџмент во Скопје и на Универзитетот Американ Колеџ Скопје.',
                    '3' => 'Дарко магистрираше економски науки на Економскиот факултет во Љубљана и е магистер по бизнис администрација и организациски науки, со специјализација во менаџментот со човечките ресурси, а исто така е дипломиран машински инженер и автор на повеќе стручни и научно-истражувачки трудови.',
                ]),
            ]
        );

        Employee::factory(2)->create([
            'role_id' => $volunteer->id
        ]);
    }
}
