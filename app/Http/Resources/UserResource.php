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
            'name' => $this->name,
            'teamId' => $this->team_id,
            'email' => $this->email,
            'verified' => !is_null($this->email_verified_at),
            'leaveBalance' => $this->leave_balance,
            'lastLoginAt' => $this->last_logged_in_at,
            'avatar' => $this->avatar,
            'permissions' => $this->permissions,
            'roles' => $this->roles,
            'avatarUrl' => $this->avatar_url,
            'totalDaysOnLeave' => $this->total_days_on_leave,
            'hasAvatar' => $this->has_avatar,
            'isOnLeave' => $this->is_on_leave,
        ];
    }
}
