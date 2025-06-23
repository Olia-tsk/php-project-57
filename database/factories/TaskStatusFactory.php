<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }

    public function predefined()
    {
        return $this->sequence(
            [
                'name' => 'новая',
            ],
            [
                'name' => 'завершена',
            ],
            [
                'name' => 'выполняется',
            ],
            [
                'name' => 'в архиве',
            ]
        );
    }
}
