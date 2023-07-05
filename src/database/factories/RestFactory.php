<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'breakIn' => $this->faker->dateTimeBetween('-6hours', '-5hours'),
            'breakOut' => $this->faker->dateTimeBetween('-4hours', '-3hours'),
            'time_id' => \App\Models\Time::factory(),
        ];
    }
}
