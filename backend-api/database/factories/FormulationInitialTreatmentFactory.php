<?php

namespace Database\Factories;

use App\Models\Formulation;
use App\Models\HeatTreatment;
use App\Models\InitialTreatment;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormulationInitialTreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $initialTreatmentId = InitialTreatment::query()->inRandomOrder()->value('id');
            $formulationId = Formulation::query()->inRandomOrder()->value('id');
            $exists = \DB::table('formulations_has_initial_treatments')
                ->where('initial_treatment_id', $initialTreatmentId)
                ->where('formulation_id', $formulationId)
                ->exists();
        } while ($exists);

        return [
            'initial_treatment_id' => $initialTreatmentId,
            'formulation_id' => $formulationId,
        ];
    }
}
