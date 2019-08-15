<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use Searchable;

    public function tracks()
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
