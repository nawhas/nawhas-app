<?php

namespace App\Transformers;

use App\Reciter;

class ReciterTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'albums',
    ];
    /**
     * @param Reciter $reciter
     * @return array
     */
    public function transform(Reciter $reciter)
    {
        return [
            'id' => $reciter->id,
            'name' => $reciter->name,
            'slug' => $reciter->slug,
            'avatar' => $reciter->avatar ?: Reciter::DEFAULT_AVATAR_URL,
            'description' => $reciter->description,
            'albumCount' => $reciter->albums()->count(),
            'createdAt' => $reciter->created_at->toDateTimeString(),
            'updatedAt' => $reciter->updated_at->toDateTimeString(),
            'links' => [
                [
                    'rel' => 'self',
                    'url' => '/v1/reciters/' . $reciter->slug,
                ],
                [
                    'rel' => 'albums',
                    'url' => '/v1/reciters/' . $reciter->slug . '/albums',
                ],
            ],
        ];
    }

    /**
     * @param Reciter $reciter
     * @return \League\Fractal\Resource\Collection
     * @internal param \App\Track $track
     *
     */
    public function includeAlbums(Reciter $reciter)
    {
        return $this->collection($reciter->albums, AlbumTransformer::excluding('reciters'));
    }
}
