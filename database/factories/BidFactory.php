<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id'=>Project::inRandomOrder()->first()->id,
            'freelancer_id'=>User::role('freelancer')->inRandomOrder()->first()->id,
            'bid'=>fake()->randomFloat(2,0,1000),
            'months'=>fake()->numberBetween(0,11),
            'days'=>fake()->numberBetween(1,30)
        ];
    }
}
