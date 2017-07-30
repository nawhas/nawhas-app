<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    public function Tracks()
    {
        return $this->belongsTo('App\Track', 'tracks_id', 'id');
    }
}
