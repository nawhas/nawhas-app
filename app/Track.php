<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use Searchable;

    public function albums()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function lyrics()
    {
        return $this->hasOne(Lyric::class, 'track_id', 'id');
    }
}
