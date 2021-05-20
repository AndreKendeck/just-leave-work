<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
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
            'teamId' => $this->team_id,
            'number' => $this->number,
            'userId' => $this->userId,
            'reason' => $this->reason,
            'description' => $this->description,
            'from' => $this->from,
            'until' => $this->until,
            'approvedAt' => $this->approved_at,
            'deniedAt' => $this->denied_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'numberOfDaysOff' => $this->number_of_days_off,
            'approved' => $this->approved,
            'pending' => $this->pending,
            'denied' => $this->denied,
            'isActive' => $this->is_active,
            'comments' => $this->comments, 
        ];
    }
}
