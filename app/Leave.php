<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $guarded = [];
    protected $appends = [
        'approved',
        'denied',
        'pending',
        'number_of_days_off',
    ];

    protected $dates = [
        'approved_at',
        'denied_at',
        'from',
        'to'
    ];

    public function deny(User $user)
    {
        $this->update([
            'denied_at' => now(),
            'denied_by' => $user->id,
            'approved_at' => null,
            'approved_by' => null
        ]);
    }

    public function approve(User $user)
    {
        $this->update([
            'approved_at' => now(),
            'approved_by' => $user->id,
            'denied_at' => null,
            'denied_by' => null,
        ]);
    }

    public function getApprovedAttribute()
    {
        return !is_null($this->approved_at) && is_null($this->denied_at);
    }

    public function getDeniedAttribute()
    {
        return !is_null($this->denied_at) && is_null($this->approved_at);
    }

    public function getPendingAttribute()
    {
        return !$this->getApprovedAttribute() && !$this->getDeniedAttribute();
    }

    public function getNumberOfDaysOffAttribute()
    {
        return $this->to->diffInDays($this->from);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function approver()
    {
        return $this->belongsTo('App\User', 'approved_by');
    }

    public function denier()
    {
        return $this->belongsTo('App\User', 'denied_by');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}
