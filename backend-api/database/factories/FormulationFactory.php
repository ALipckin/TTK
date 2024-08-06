<?php

namespace Database\Factories;

use App\Models\heat_treatment;
use App\Models\initial_processing;
use App\Models\Product;
use App\Models\Ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formulation>
 */
class FormulationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $index = 0;

    public function definition(): array
    {
        $ttkIds = TTK::whereDoesntHave('Formulations')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index];

        static::$index++;

        return [
        'netto' => random_int(1,10)/10,
        'brutto' => random_int(1,10)/10,
        'package' => $this->faker->word(),
        'product_id' => Product::query()->inRandomOrder()->value('id'),
        'ttk_id' => $ttkId,
        'initial_processing_id' => initial_processing::query()->inRandomOrder()->value('id'),
        'heat_treatment_id'=> heat_treatment::query()->inRandomOrder()->value('id'),
        ];
    }
}
