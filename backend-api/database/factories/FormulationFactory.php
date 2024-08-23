<?php

namespace Database\Factories;

use App\Models\HeatTreatment;
use App\Models\InitialTreatment;
use App\Models\Package;
use App\Models\Product;
use App\Models\Ttk;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $ttkIds = Ttk::whereDoesntHave('Formulations')->pluck('id')->toArray();
        $index = static::$index % count($ttkIds);
        $ttkId = $ttkIds[$index];

        static::$index++;

        return [
            'netto' => random_int(1, 10) / 10,
            'brutto' => random_int(1, 10) / 10,
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'ttk_id' => $ttkId,
            'package_id' => Package::query()->inRandomOrder()->value('id'),
        ];
    }
}
