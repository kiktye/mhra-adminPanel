<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneralInfo>
 */
class GeneralInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Македонска Асоцијација за Човечки Ресурси',
            'subtitle' => 'Луѓето пред се!',
            'photo_path' => $this->faker->imageUrl(360, 360, 'events', true),
            'social_links' => json_encode([
                [
                    'platform' => 'facebook',
                    'link' => $this->faker->url(),
                ],
                [
                    'platform' => 'twitter',
                    'link' => $this->faker->url(),
                ],
                [
                    'platform' => 'linkedin',
                    'link' => $this->faker->url(),
                ]
            ]),
        ];
    }
}
