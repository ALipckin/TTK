<?php

namespace App\Http\Resources\InitialTreatment;

use App\Models\Formulation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InitialTreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $initialTreatments = Formulation::find($this->id)->initialTreatment()->get(['id', 'title'])->makeHidden('pivot');;

        return [
            'initial_treatments' => $initialTreatments,
        ];
    }
}
