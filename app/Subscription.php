<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    use HasFactory;

    /**
     * @var array
     */
    protected $appends = [
        'expired',
        'is_active',
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    /**
     * @return \App\Team
     */
    public function team()
    {
        return $this->belongsTo(\App\Team::class);
    }

    /**
     * @return boolean
     */
    public function getExpiredAttribute(): bool
    {
        return today() > $this->ends_at;
    }

    public function payment()
    {
        return $this->hasOne(\App\SubscriptionPayment::class)->where('successful', true);
    }

    /**
     * @return boolean
     */
    public function isActiveAttribute(): bool
    {
        return $this->ends_at < today();
    }

}
