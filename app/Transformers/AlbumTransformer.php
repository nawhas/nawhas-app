<?php

namespace App\Transformers;

use App\Album;
use League\Fractal\TransformerAbstract;

class AlbumTransformer extends TransformerAbstract
{
    /**
     * @param Album $album
     * @return array
     */
    public function transform(Album $album)
    {
        return [
            'id' => $album->id,
            'reciter_id' => $album->reciter_id,
            'name' => $album->name,
            'year' => $album->year,
            'hijri_year' => $album->hijri_year,
            'hijri_month' => $album->hijri_month,
            'artwork' => $album->artwork,
            'created_at' => $album->created_at->toDateTimeString(),
            'updated_at' => $album->updated_at->toDateTimeString(),
        ];
    }
}
