<?php

namespace Database\Factories;

use App\Models\Proyek;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scope>
 */
class ScopeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectIds = Proyek::pluck('id_project')->toArray();
        return [
            'nama' => fake()->sentence(3),
            'project_id' => fake()->randomElement($projectIds),
            'isActive' => 1,
        ];
    }
}
