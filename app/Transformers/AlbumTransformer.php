<?php

namespace App\Transformers;

use App\Album;

class AlbumTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'tracks',
        'reciter',
    ];

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
            'artwork' => $album->artwork ?: Album::DEFAULT_ARTWORK_URL,
            'created_at' => $album->created_at->toDateTimeString(),
            'updated_at' => $album->updated_at->toDateTimeString(),
        ];
    }

    /**
     * @param \App\Album $album
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTracks(Album $album)
    {
        return $this->collection($album->tracks, TrackTransformer::excluding('album'));
    }

    /**
     * @param \App\Album $album
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeReciter(Album $album)
    {
        return $this->item($album->reciter, ReciterTransformer::excluding('albums'));
    }
}
