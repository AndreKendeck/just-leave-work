<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leave extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    protected $observables = [
        'approved',
        'denied',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'number_of_days_off',
        'approved',
        'pending',
        'denied',
        'is_active',
        'can_delete',
        'can_edit',
        'is_for_one_day',
    ];

    /**
     * @var array
     */
    protected $withCount = [
        'comments',
    ];

    protected $casts = [
        'team_id' => 'integer',
        'reason_id' => 'integer',
        'number' => 'integer',
        'half_day' => 'boolean',
    ];

    protected $with = [
        'reason',
        'comments',
    ];

    protected $dates = [
        'from',
        'until',
        'approved_at',
        'denied_at',
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

        $this->fireModelEvent('approved', false);
        $this->update([
            'approved_at' => now(),
        ]);
    }

    public function deny()
    {
        $this->fireModelEvent('denied', false);
        $this->update([
            'denied_at' => now(),
        ]);
    }

    public function getNumberOfDaysOffAttribute()
    {
        $difference = $this->until->diffInDays($this->from);

        if ($this->half_day) {
            return 0.5;
        }

        if ($difference > 0) {

            $excludedDays = $this->team->settings->excludedDays;

            $daysOff = 1;

            for ($d = 1; $d <= $difference; $d++) {

                $nextDay = $this->from->addDays($d)->format('l');

                if ($excludedDays->contains('day', $nextDay)) {
                    continue;
                }
                $daysOff++;
            }

            return $daysOff;
        }

        if ($this->until->isSameDay($this->from)) {
            return 1;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
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

    public function getCanDeleteAttribute()
    {
        return ($this->user_id == auth()->user()->id) && ($this->pending);
    }

    public function getCanEditAttribute()
    {
        return ($this->user_id == auth()->user()->id) && ($this->pending);
    }

    public function getIsForOneDayAttribute()
    {
        return $this->from->isSameDay($this->until);
    }

    public function getPendingAttribute()
    {
        return (is_null($this->approved_at) && is_null($this->denied_at));
    }

    public function document()
    {
        return $this->morphOne(\App\Document::class, 'documentable');
    }
}
