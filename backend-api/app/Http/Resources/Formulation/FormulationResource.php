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

        return [
            'id' => $this->id,
            'netto' => $this->netto,
            'brutto' => $this->brutto,
            'product_id' => $this->product_id,
            'product_name' => $productName,
            'treatment_id' => $this->treatment_id,
        ];
    }
}
