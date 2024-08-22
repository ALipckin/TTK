<?php

namespace App\Http\Resources\Formulation;

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

        return [
            'id' => $this->id,
            'netto' => $this->netto,
            'brutto' => $this->netto,
            'package_id' => $this->package_id,
            'package_name' => $packageName,
            'product_id' => $this->product_id,
            'product_name' => $productName,
        ];
    }
}
