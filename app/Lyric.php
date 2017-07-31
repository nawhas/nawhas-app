<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Track;

class Lyric extends Model
{
    public function tracks()
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
