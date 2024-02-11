<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TTK>
 */
class TTKFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           =>  $this->faker->word,
            'image'          =>  $this->faker->imageUrl(),
            'open'           =>  rand(0,1),
            'users_id'       =>  User::get()->random()->id
        ];
    }
}
