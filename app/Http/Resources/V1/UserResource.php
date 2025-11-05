<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'email' => $this->email,
                'name' => $this->name,
//                'created_at' => $this->when(request()->routeIs('api.v1.users.*'), $this->created_at),
//                'updated_at' => $this->when(request()->routeIs('api.v1.users.*'), $this->updated_at),
                $this->mergeWhen(request()->routeIs('api.v1.users.*'), [
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                ])
            ],
            'relationships' => [],
            'links' => [
                'self' => route('api.v1.users.show', ['user' => $this->id]),
            ],
        ];
    }
}
