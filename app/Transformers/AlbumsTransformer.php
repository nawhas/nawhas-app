<?php

namespace App\Transformers;

use App\Album;
use League\Fractal\TransformerAbstract;

class AlbumsTransformer extends TransformerAbstract
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
            'image' => $album->image_path,
            'created_at' => $album->created_at->toDateString(),
            'updated_at' => $album->updated_at->toDateString(),
        ];
    }
}
