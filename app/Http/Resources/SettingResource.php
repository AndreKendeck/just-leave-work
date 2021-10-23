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
            'leaveAddedPerCycle' => $this->leave_added_per_cycle,
            'daysUntilBalanceAdded' => $this->days_until_balance_added,
            'lastLeaveBalanceAddedAt' => $this->last_leave_balance_added_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'excludedDays' => ExcludedDayResource::collection($this->excludedDays),
            'country' => $this->country_id,
            'usePublicHolidays' => $this->use_public_holidays,
        ];
    }
}
