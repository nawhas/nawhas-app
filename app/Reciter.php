<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
    public function Albums()
    {
        return $this->hasMany('App\Album', 'reciters_id', 'id');
    }
}
