<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => '13та меѓународна МАЧР конференција',
            'description' => 'Годишната меѓународна HR конференција, организирана од страна на Македонска асоцијација за човечки ресурси, има за цел да ги истражи и презентира најновите трендови и практики во областа на човечките ресурси кои ќе им помогнат на организациите да станат "future fit". Оваа конференција ќе ги собере најдобрите умови и лидери во HR за да дискутираат и разменат идеи за проактивни стратегии кои можат да ја трансформираат работната сила и да ја унапредат организациската ефикасност.',
            'location' => 'Хотел Континентал, Скопје',
            'start_date' => '2024-12-24',
            'end_date' => '2024-12-25',
            'ticket_packages' => json_encode([
                [
                    'type' => 'Поединци',
                    'price' => '1500',
                    'option' => ['1 седиште', 'Пауза за ручек', 'WiFi']
                ],
                [
                    'type' => 'Корпорации',
                    'price' => '5000',
                    'option' => ['20 седишста', 'Пауза за чај и кафе', 'Пауза за ручек', 'WiFi']
                ]
            ]),
            'status' => 'active',
            'agenda_id' => null,
            'photo_path' => $this->faker->imageUrl(640, 480, 'events', true),
        ];
    }
}
