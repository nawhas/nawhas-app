<?php

namespace App;

use JordanMiguel\LaravelPopular\Traits\Visitable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use Visitable, Searchable;

    public function reciters()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'album_id', 'id');
    }
}
