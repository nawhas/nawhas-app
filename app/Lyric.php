<?php

namespace App;

use \JordanMiguel\LaravelPopular\Traits\Visitable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use Visitable, Searchable;

    public function tracks()
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
