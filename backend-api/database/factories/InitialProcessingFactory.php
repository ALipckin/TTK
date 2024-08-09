<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InitialProcessingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'loss' => random_int(0,10)/10,
        ];
    }
}
