<?php

namespace Database\Factories;

use App\Models\ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrgCharacteristicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;

    public function definition(): array
    {
        $ttkIds = ttk::whereDoesntHave('orgCharacteristics')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index];

        static::$index++;

        return [
            'look' => $this->faker->word(),
            'color' => $this->faker->word(),
            'consistency' => $this->faker->word(),
            'flavor' => $this->faker->word(),
            'ttk_id' => $ttkId
        ];
    }
}
