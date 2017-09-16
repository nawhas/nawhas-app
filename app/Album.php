<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use Searchable;

    protected $fillable = [
        'year', 'name',
    ];

    public function reciters()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'album_id', 'id');
    }
}
