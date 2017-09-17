<?php

namespace App;

use JordanMiguel\LaravelPopular\Traits\Visitable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
    use Visitable, Searchable;

    protected $fillable = ['name'];

    public function albums()
    {
        return $this->hasMany(Album::class, 'reciter_id', 'id');
    }
}
