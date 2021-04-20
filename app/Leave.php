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

    /**
     * @var array
     */
    protected $appends = [
        'number_of_days_off',
        'approved',
        'pending',
        'denied',
        'is_active',
    ];

    /**
     * @var array
     */
    protected $withCount = [
        'comments',
    ];

    protected $casts = [
        'team_id' => 'integer',
        'from' => 'datetime:Y-m-d',
        'until' => 'datetime:Y-m-d',
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
        $this->fireCustomModelEvent('approved', 'approved');
        $this->update([
            'approved_at' => now(),
        ]);
    }

    public function deny()
    {
        $this->fireCustomModelEvent('denied', 'denied');
        $this->update([
            'denied_at' => now(),
        ]);
    }

    public function getNumberOfDaysOffAttribute()
    {
        return $this->until->diffInDays($this->from);
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

    public function getPendingAttribute()
    {
        return (is_null($this->approved_at) && is_null($this->denied_at));
    }
}
