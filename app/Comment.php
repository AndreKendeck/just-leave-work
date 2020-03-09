<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $appends = [
        'was_edited',
        'can_edit'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function leave()
    {
        return $this->belongsTo('App\Leave');
    }

    public function getWasEditedAttribute()
    {
        return $this->created_at < $this->updated_at;
    }

    public function getCanEditAttribute()
    {
        if (auth()->check()) {
            return $this->user_id == auth()->user()->id;
        }
        return false;
    }
}
