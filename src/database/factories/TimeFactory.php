<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TimeFactory extends Factory
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
            'punchIn' => $this->faker->dateTimeBetween('-12hours', '-8hours'),
            'punchOut' => $this->faker->dateTimeBetween('+2hours', '+6hours'),
            'date' => $this->faker->dateTimeBetween('-1day', '+1day'),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
