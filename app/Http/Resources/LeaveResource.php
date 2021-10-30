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
            'reason' => $this->reason,
            'description' => $this->description,
            'from' => $this->from,
            'until' => $this->until,
            'approvedAt' => $this->approved_at,
            'deniedAt' => $this->denied_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'numberOfDaysOff' => $this->number_of_days_off,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatarUrl' => $this->user->avatar_url,
            ],
            'approved' => $this->approved,
            'pending' => $this->pending,
            'denied' => $this->denied,
            'isActive' => $this->is_active,
            'comments' => CommentResource::collection($this->comments),
            'canEdit' => $this->can_edit,
            'canDelete' => $this->can_delete,
            'isForOneDay' => $this->is_for_one_day,
            'halfDay' => $this->half_day,
            'lastSentAt' => $this->last_sent_at
        ];
    }
}
