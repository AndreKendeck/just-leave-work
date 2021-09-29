<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $guarded = [];

    public const STORAGE_PATH = '/storage/documents/';

    public function documentable()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        Storage::disk('public')->delete(self::STORAGE_PATH . $this->name);
        return parent::delete();
    }
}
