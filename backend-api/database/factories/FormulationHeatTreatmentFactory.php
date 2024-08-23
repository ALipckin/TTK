<?php

namespace Database\Factories;

use App\Models\Formulation;
use App\Models\HeatTreatment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormulationHeatTreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $heatTreatmentId = HeatTreatment::query()->inRandomOrder()->value('id');
            $formulationId = Formulation::query()->inRandomOrder()->value('id');
            $exists = \DB::table('formulations_has_heat_treatments')
                ->where('heat_treatment_id', $heatTreatmentId)
                ->where('formulation_id', $formulationId)
                ->exists();
        } while ($exists);

        return [
            'heat_treatment_id' => $heatTreatmentId,
            'formulation_id' => $formulationId,
        ];
    }
}
