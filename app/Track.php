<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Album;
use App\Lyric;

class Track extends Model
{
    public function albums()
    {
        return $this->belongsTo(Album::class, 'albums_id', 'id');
    }

    public function lyrics()
    {
        return $this->hasOne(Lyric::class, 'tracks_id', 'id');
    }
}
