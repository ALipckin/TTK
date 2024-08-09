<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
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
            'name'          => $this->faker->word,
            'protein'      =>  random_int(0,10)/10,
            'carbs'       =>  random_int(0,10)/10,
            'fat'         =>   random_int(0,10)/10,
            'water'         =>  random_int(0,10)/10,
            'fiber'        =>  random_int(0,10)/10,
            'ash'           =>  random_int(0,10)/10,
            'category_id'           =>  Category::get()->random()->id,
        ];
    }
}
