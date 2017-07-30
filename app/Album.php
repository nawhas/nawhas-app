<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function Reciters()
    {
        return $this->belongsTo('App\Reciter', 'reciters_id', 'id');
    }

    public function Tracks()
    {
        return $this->hasMany('App\Track', 'albums_id', 'id');
    }
}
