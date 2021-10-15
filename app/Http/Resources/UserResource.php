<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'teamId' => $this->team_id,
            'email' => $this->email,
            'verified' => !is_null($this->email_verified_at),
            'leaveBalance' => $this->balance,
            'lastLoginAt' => $this->last_logged_in_at,
            'avatar' => $this->avatar,
            'isAdmin' => $this->roles->contains('name', 'team-admin'),
            'avatarUrl' => $this->avatar_url,
            'totalDaysOnLeave' => $this->total_days_on_leave,
            'isOnLeave' => $this->is_on_leave,
            'leaveTaken' => $this->leave_taken,
            'lastLeaveAt' => $this->last_leave_at,
            'unreadNotifications' => $this->unreadNotifications->count(),
            'jobPosition' => $this->job_position,
            'isBanned' => !is_null($this->banned_at),
        ];
    }
}
