<?php

namespace Database\Factories;

use App\Models\ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealizationRequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;

    public function definition(): array
    {
        $ttkIds = ttk::whereDoesntHave('realizationRequirements')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index] ?? Ttk::Factory();

        static::$index++;

        return [
            'description' => $this->faker->sentence(5),
            'ttk_id' => $ttkId
        ];
    }
}
