<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TtkCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'view' => $this->faker->imageUrl(),
            'color' => $this->faker->word,
            'cons' => $this->faker->word,
            'taste' => $this->faker->word,
            'fat' => $this->faker->numberBetween(0, 100),
            'fdry' => $this->faker->numberBetween(0, 100),
            'fsug' => $this->faker->numberBetween(0, 100),
            'fsalt' => $this->faker->numberBetween(0, 100),
            'gerb' => $this->faker->numberBetween(0, 100),
            'bgkp' => $this->faker->numberBetween(0, 20),
            'ecoli' => $this->faker->numberBetween(0, 20),
            'saur' => $this->faker->numberBetween(0, 20),
            'prot' => $this->faker->numberBetween(0, 20),
            'pato' => $this->faker->numberBetween(0, 20),
            'dryk' => $this->faker->randomFloat(20, 2),
            'smax' => $this->faker->randomFloat(20, 2),
            'sp' => $this->faker->word,
            'rem' => $this->faker->text,
        ];
    }
}
