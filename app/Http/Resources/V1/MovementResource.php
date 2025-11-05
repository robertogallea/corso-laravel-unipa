<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'movement',
            'id' => $this->id,
            'attributes' => [
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'user' => new UserResource($this->whenLoaded('user')),
            ],
            'links' => [
                'self' => route('api.v1.movements.show', ['movement' => $this->id]),
            ],
        ];
    }
}
