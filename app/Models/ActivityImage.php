<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityImage extends Model
{
    protected $fillable = ['activity_id', 'image_url', 'is_primary'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}