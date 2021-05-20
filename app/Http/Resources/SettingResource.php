<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'automaticLeaveApproval' => $this->automatic_leave_approval,
            'leaveAddedPerCycle' => $this->leave_added_per_cycle,
            'maximumLeaveDays' => $this->maximum_leave_days,
            'maximumLeaveBalance' => $this->maximum_leave_balance,
            'daysUntilBalanceAdded' => $this->days_until_balance_added,
            'canApproveOwnLeave' => $this->can_approve_own_leave,
            'lastLeaveBalanceAddedAt' => $this->last_leave_balance_added_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
