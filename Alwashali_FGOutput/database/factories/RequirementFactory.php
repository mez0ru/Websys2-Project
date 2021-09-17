<?php

namespace Database\Factories;

use App\Models\Requirement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequirementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Requirement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gender' => 'Both',
            'age' => $this->faker->numberBetween(16, 60),
            'country' => $this->faker->country(),
            'qualifications' => $this->faker->paragraph(),
            'min_work_experience' => $this->faker->numberBetween(0, 5),
            'min_work_experience_range_type' => 'Year'
        ];
    }
}
