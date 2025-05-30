<?php

namespace Database\Factories;

use App\Models\TasksModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TasksModelFactory extends Factory
{
    protected $model = TasksModel::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            // Add other fields as needed, for example:
            // 'status' => $this->faker->randomElement(['pending', 'completed']),
            // 'user_id' => \App\Models\User::factory(),
        ];
    }
}