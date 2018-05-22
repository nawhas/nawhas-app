<?php

namespace App\Transformers;

use App\Track;

class TrackTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'album',
        'reciter',
    ];

    /**
     * @param Track $track
     *
     * @return array
     */
    public function transform(Track $track)
    {
        $lyrics = $track->lyrics()->latest()->first();
        return [
            'id' => $track->id,
            'slug' => $track->slug,
            'name' => $track->name,
            'audio' => $track->audio,
            'video' => $track->video,
            'number' => $track->number,
            'lyrics' => $lyrics ? nl2br($lyrics->text) : null,
            'created_at' => $track->created_at->toDateTimeString(),
            'updated_at' => $track->updated_at->toDateTimeString(),
            'links' => [
                [
                    'rel' => 'self',
                    'url' => '/v1/reciters/' . $track->reciter->slug . '/albums/' . $track->album->year . '/' . $track->slug,
                ],
                [
                    'rel' => 'album',
                    'url' => '/v1/reciters/' . $track->reciter->slug . '/albums/' . $track->album->year,
                ],
                [
                    'rel' => 'reciter',
                    'url' => '/v1/reciters/' . $track->reciter->slug,
                ],
            ]
        ];
    }

    /**
     * @param \App\Track $track
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAlbum(Track $track)
    {
        return $this->item($track->album, AlbumTransformer::excluding('tracks'));
    }

    /**
     * @param \App\Track $track
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeReciter(Track $track)
    {
        return $this->item($track->reciter, new ReciterTransformer());
    }
}
