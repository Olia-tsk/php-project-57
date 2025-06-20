<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (TaskStatus::STATUSES as $status) {
            TaskStatus::firstOrCreate(['name' => $status]);
        }
    }
}
