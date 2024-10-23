<?php

namespace Database\Factories;

use App\Models\Treatment;
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
        $productId = Product::query()->where('user_id', null)->inRandomOrder()->value('id') ?? Ttk::Factory();
        static::$index++;

        return [
            'netto' => random_int(1, 10) / 10,
            'brutto' => random_int(1, 10) / 10,
            'product_id' => $productId,
            'treatment_id' => Treatment::query()->where('product_id', $productId)->inRandomOrder()->value('id'),
            'ttk_id' => $ttkId,
        ];
    }
}
