<?php

namespace App\Http\Resources\Formulation;

use App\Models\Formulation;
use App\Models\InitialTreatment;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormulationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productName = Product::where('id', $this->product_id)->pluck('name')->first();
        $packageName = Package::where('id', $this->package_id)->pluck('title')->first();
        $initialTreatments = Formulation::find($this->id)->initialTreatment()->get(['id', 'title'])->makeHidden('pivot');;
        $heatTreatments = Formulation::find($this->id)->heatTreatment()->get(['id', 'title'])->makeHidden('pivot');

        return [
            'formulation' => [
                'id' => $this->id,
                'netto' => $this->netto,
                'brutto' => $this->netto,
                'package_id' => $this->package_id,
                'package_name' => $packageName,
                'product_id' => $this->product_id,
                'product_name' => $productName,
            ],
            'initial_treatments' => $initialTreatments,
            'heat_treatments' => $heatTreatments,
        ];
    }
}
