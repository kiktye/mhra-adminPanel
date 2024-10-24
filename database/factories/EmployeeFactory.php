<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'title' => $this->faker->jobTitle(),
            'photo_path' => $this->faker->imageUrl(360, 360, 'people', true),
            'social_links' => json_encode([
                [
                    'platform' => 'facebook',
                    'link' => $this->faker->url(),
                ],
                [
                    'platform' => 'instagram',
                    'link' => $this->faker->url(),
                ],
                [
                    'platform' => 'linkedin',
                    'link' => $this->faker->url(),
                ]
            ]),
            'role_id' => null,
            'description' => json_encode([

                '0' => $this->faker->paragraph(),
                '1' => $this->faker->paragraph(),
                '2' => $this->faker->paragraph(),
                '3' => $this->faker->paragraph(),
            ]),
        ];
    }
}
