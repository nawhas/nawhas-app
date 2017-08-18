<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
    use Searchable;

    public function albums()
    {
        return $this->hasMany(Album::class, 'reciter_id', 'id');
    }
}
