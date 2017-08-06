<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function reciters()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'album_id', 'id');
    }
}
