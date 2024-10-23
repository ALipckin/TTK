<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {

        return [
            'name' => $this->faker->word,
            'unit' => 100,
            'grm' => 100,
            'protein' => random_int(0, 100),
            'carbs' => random_int(0, 100),
            'fat' => random_int(0, 100),
            'water' => random_int(0, 100),
            'fiber' => random_int(0, 100),
            'dry' => random_int(0, 100),
            'alko' => random_int(0, 100),
            'sug' => random_int(0, 100),
            'ash' => random_int(0, 100),
            'rem' => $this->faker->text(),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
