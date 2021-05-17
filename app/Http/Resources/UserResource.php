<?php

namespace App\Http\Resources;

use App\Permission;
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
            'leaveBalance' => $this->leave_balance,
            'lastLoginAt' => $this->last_logged_in_at,
            'avatar' => $this->avatar,
            'roles' => $request->roles,
            'permissions' => $request->permissions,
            'avatarUrl' => $this->has_avatar ? $this->avatar_url : $this->avatar_url->encoded,
            'totalDaysOnLeave' => $this->total_days_on_leave,
            'hasAvatar' => $this->has_avatar,
            'isOnLeave' => $this->is_on_leave,
        ];
    }
}
