<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $status = TaskStatus::inRandomOrder()->first() ?? TaskStatus::factory()->create();

        $creator = User::factory()->create();
        $executor = $this->faker->boolean(50) ? User::factory()->create() : null;

        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentences(3, true),
            'status_id' => $status->id,
            'created_by_id' => $creator->id,
            'assigned_to_id' => $executor ? $executor->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
