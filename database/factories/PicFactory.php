<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Bagian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pic>
 */
class PicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bagianIds = Bagian::pluck('master_bagian_id')->toArray();
        $activityIds = Activity::pluck('id_activity')->toArray();
        return [
            'bagian_id' => fake()->randomElement($bagianIds),
            'activity_id' => fake()->randomElement($activityIds),
        ];
    }
}
