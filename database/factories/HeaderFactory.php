<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Product>
 */
class HeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;
    public function definition(): array
    {
        $ttkIds = TTK::whereDoesntHave('headers')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index];

        static::$index++;
        return [
            'company'            =>  $this->faker->word,
            'property'           =>  $this->faker->sentence(2),
            'position'           =>  $this->faker->word,
            'approver'           =>  $this->faker->name,
            'card'               =>  $this->faker->numerify,
            'created_date'       =>  $this->faker->date,
            'dish'               =>  $this->faker->word(),
            'dev'                =>  $this->faker->name,
            'approver2'          =>  $this->faker->name,
            'approver2_position' =>  $this->faker->word(),
            "ttk_id"    => $ttkId
        ];
    }

}
