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
        'leave_added_per_cycle' => 'integer',
        'days_until_balance_added' => 'integer',
        'last_leave_balance_added_at' => 'datetime',
        'use_public_holidays' => 'boolean',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function team()
    {
        return $this->belongsTo(\App\Team::class);
    }

    public function excludedDays()
    {
        return $this->hasMany(\App\ExcludedDay::class)->latest();
    }
}
