<?php

namespace App;

use App\Scopes\DefaultSortScope;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
    use Visitable, Searchable;

    const DEFAULT_AVATAR_URL = 'https://s3.us-east-2.amazonaws.com/nawhas/defaults/reciter.png';

    /** @var array */
    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DefaultSortScope('name'));
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'reciter_id', 'id');
    }
}
