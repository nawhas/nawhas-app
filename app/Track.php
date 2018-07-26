<?php

namespace App;

use App\Scopes\DefaultSortScope;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use Visitable, Searchable;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DefaultSortScope('number', 'asc'));
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function reciter()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id', 'id');
    }

    public function lyrics()
    {
        return $this->hasOne(Lyric::class, 'track_id', 'id');
    }

    public function language()
    {
        return $this->belongsToMany('App\Language', 'track_languages','track_id', 'language_id');
    }
}
