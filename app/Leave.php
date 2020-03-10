<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leave extends Model
{
    protected $guarded = [];
    protected $appends = [
        'approved',
        'denied',
        'pending',
        'number_of_days_off',
        'can_edit'
    ];

    protected $dates = [
        'approved_at',
        'denied_at',
        'from',
        'until'
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
        return $this->until->diffInDays($this->from);
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

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->number = DB::table('leaves')->where('organization_id', $model->organization_id)->count() + 1;
        });
    }

    public function getCanEditAttribute()
    {
        if (auth()->check()) {
            // prevent the user from editing if the leave has been approved or denied
            if ($this->getApprovedAttribute() || $this->getDeniedAttribute()) {
                return false;
            }
            return $this->user_id == auth()->user()->id;
        }
        return false;
    }
}
