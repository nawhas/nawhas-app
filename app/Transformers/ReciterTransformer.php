<?php

namespace App\Transformers;

use App\Reciter;

class ReciterTransformer extends Transformer
{
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
            ]
        ];
    }
}
