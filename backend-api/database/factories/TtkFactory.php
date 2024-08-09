<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TtkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          =>  $this->faker->word,
            'image'         =>  $this->faker->imageUrl(),
            'public'        =>  rand(0,1),
            'user_id'       =>  User::get()->random()->id
        ];
    }
}
