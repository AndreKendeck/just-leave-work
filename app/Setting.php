<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];


    protected $casts = [
        'automatic_leave_approval' => 'boolean',
        'leave_added_per_cycle' => 'integer', 
        'maximum_leave_days' => 'integer', 
        'maximum_leave_balance' => 'integer', 
        'days_until_balance_added' => 'integer', 
        'can_approve_own_leave' => 'boolean'
    ];

    public function team()
    {
        return $this->belongsTo(\App\Team::class);
    }
}
