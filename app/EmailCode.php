<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EmailCode extends Model
{
    protected $guarded = [];

    public $incrementing = false; 

    /**
     * @var string
     */
    protected $keyType = 'string';

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return boolean|null
     */
    public function hasExpired(): ?bool
    {
        return now() > $this->expires_at;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = Uuid::uuid4());
    }
}
