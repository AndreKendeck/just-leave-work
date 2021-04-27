<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'automatic_leave_approval' => 'boolean',
        'leave_added_per_cycle' => 'integer',
        'maximum_leave_days' => 'integer',
        'maximum_leave_balance' => 'integer',
        'days_until_balance_added' => 'integer',
        'can_approve_own_leave' => 'boolean',
        'last_leave_balance_added_at' => 'datetime'
    ];

    public function team()
    {
        return $this->belongsTo(\App\Team::class);
    }
}
