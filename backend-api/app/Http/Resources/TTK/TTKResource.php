<?php

namespace App\Http\Resources\TTK;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TTKResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'open' => $this->public,
            'users_ID' => $this->users_id,
            'isDraft' => $this->isDraft,
        ];
    }
}
