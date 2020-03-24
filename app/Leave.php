<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leave extends Model
{
    protected $guarded = [];
    protected $appends = [
        'number_of_days_off',
        'can_edit',
        'approved',
        'denied',
        'is_active'
    ];
    protected $with = [
        'reason'
    ];
    protected $dates = [
        'from',
        'until',
        'approved_at',
        'denied_at'
    ];

    public function getApprovedAttribute()
    {
        return !is_null($this->approved_at);
    }

    public function reason()
    {
        return $this->belongsTo('App\Reason');
    }

    public function getDeniedAttribute()
    {
        return !is_null($this->denied_at);
    }

    public function getIsActiveAttribute()
    {
        if ($this->from->equalTo(today())) {
            return true;
        }
        if ($this->until->greaterThan(today()) && $this->from->lessThan(today())) {
            return true;
        }
        return false;
    }

    public function approve()
    {
        $this->approval()->save(new Approval([
            'user_id' => auth()->user()->id,
        ]));
    }

    public function deny()
    {
        $this->denial()->save(new Denial([
            'user_id' => auth()->user()->id
        ]));
    }

    public function approval()
    {
        return $this->hasOne('App\Approval')->latest();
    }

    public function denial()
    {
        return $this->hasOne('App\Denial')->latest();
    }

    public function getNumberOfDaysOffAttribute()
    {
        return $this->until->diffInDays($this->from);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->number = DB::table('leaves')->where('team_id', $model->team_id)->count() + 1;
        });
    }


    public function getCanEditAttribute()
    {
        if (auth()->check()) {
            return $this->user_id == auth()->user()->id;
        }
        return false;
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeDenied($query)
    {
        return $query->whereNotNull('denied_at');
    }
}
