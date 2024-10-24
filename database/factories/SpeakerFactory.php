<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speaker>
 */
class SpeakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'title' => $this->faker->jobTitle(),
            'photo_path' => $this->faker->imageUrl(360, 360, 'people', true),
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
            'event_id' => null,
        ];
    }
}
