<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Album;

class Reciter extends Model
{
    public function albums()
    {
        return $this->hasMany(Album::class, 'reciters_id', 'id');
    }
}
