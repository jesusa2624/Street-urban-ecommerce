<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Avatar extends Model
{
    protected $fillable = ['path'];

    protected $appends = ['url'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
