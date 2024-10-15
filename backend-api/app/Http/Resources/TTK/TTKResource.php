<?php

namespace App\Http\Resources\TTK;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;


class TTKResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $user_name = User::where('id', $this->user_id)->value('name');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'public' => $this->public,
            'user_id' => $this->user_id,
            'user_name' => $user_name,
            'isDraft' => $this->isDraft,
        ];
    }
}
