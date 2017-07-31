<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reciter;
use App\Track;

class Album extends Model
{
    public function reciters()
    {
        return $this->belongsTo(Reciter::class, 'reciters_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'albums_id', 'id');
    }
}
