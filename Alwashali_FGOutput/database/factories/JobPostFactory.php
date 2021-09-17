<?php

namespace Database\Factories;

use App\Models\JobPost;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'job_description' => $this->faker->paragraph(),
            'salary_from' => $this->faker->numberBetween(10000, 13000),
            'salary_to' => $this->faker->numberBetween(16000, 50000),
            'requirement_id' => Requirement::pluck('id')->random(),
            'apply_until' => $this->faker->dateTimeBetween('now', '+8 week'),
            'social_media_accounts' => $this->faker->sentence()
        ];
    }
}
