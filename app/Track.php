<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    public function Albums()
    {
        return $this->belongsTo('App\Album', 'albums_id', 'id');
    }

    public function Lyrics()
    {
        return $this->hasOne('App\Lyric', 'tracks_id', 'id');
    }
}
