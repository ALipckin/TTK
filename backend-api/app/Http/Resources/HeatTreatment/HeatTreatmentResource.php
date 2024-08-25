<?php

namespace App\Http\Resources\HeatTreatment;

use App\Models\Formulation;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeatTreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $heatTreatments = Formulation::find($this->id)->heatTreatment()->get(['id', 'title'])->makeHidden('pivot');

        return [
            'heat_treatments' => $heatTreatments,
        ];
    }
}
