<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Requirement;
use App\Models\Ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requirement>
 */
class TPFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;

    public function definition(): array
    {
        $ttkIds = TTK::whereDoesntHave('Tps')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index];

        static::$index++;

        return [
            'description' => $this->faker->sentence(5),
            'ttk_id' => $ttkId
        ];
    }
}
