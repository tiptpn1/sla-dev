<?php

namespace Database\Factories;

use App\Models\Scope;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $scope = Scope::inRandomOrder()->first();

        // Cek apakah scope ada dan memiliki project yang valid
        if (!$scope || !$scope->project) {
            throw new Exception("Scope atau Project terkait tidak ditemukan!");
        }
        return [
            'nama_activity' => fake()->sentence(5),
            'plan_start' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'plan_duration' => fake()->numberBetween(1, 10),
            'actual_start' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'actual_duration' => fake()->numberBetween(1, 10),
            'percent_complete' => fake()->numberBetween(1, 100),
            'scope_id' => $scope->id,
            'project_id' => $scope->project->id_project,
            'isActive' => 1
        ];
    }
}
