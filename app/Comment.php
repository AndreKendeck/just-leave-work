<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $appends = [
        'was_edited',
        'can_edit',
        'is_deletable',
        'is_editable',
    ];
    protected $with = [
        'user'
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

    public function getIsDeletableAttribute()
    {
        return now()->diffInMinutes($this->created_at) <= 5;
    }

    public function getIsEditableAttribute()
    {
        return now()->diffInMinutes($this->created_at) <= 5;
    }
}
