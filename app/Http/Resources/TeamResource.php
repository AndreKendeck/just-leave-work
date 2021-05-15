<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'displayName' => $this->displayName,
            'users' => $this->users->count(),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'numberOfApprovedLeaves' => $this->leaves()->whereNotNull('approved_at')->count()
        ];
    }
}
