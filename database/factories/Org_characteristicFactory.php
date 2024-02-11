<?php

namespace Database\Factories;

use App\Models\Ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Org_characteristicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;

    public function definition(): array
    {
        $ttkIds = TTK::whereDoesntHave('Org_characteristics')->pluck('id')->toArray();
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
