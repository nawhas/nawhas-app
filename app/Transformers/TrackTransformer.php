<?php

namespace App\Transformers;

use App\Track;

class TrackTransformer extends Transformer
{
    /**
     * @param Track $track
     * @return array
     */
    public function transform(Track $track)
    {
        return [
            'id' => $track->id,
            'slug' => $track->slug,
            'album_id' => $track->album_id,
            'name' => $track->name,
            'audio' => $track->audio,
            'video' => $track->video,
            'number' => $track->number,
            'language' => $track->language,
            'created_at' => $track->created_at->toDateTimeString(),
            'updated_at' => $track->updated_at->toDateTimeString(),
        ];
    }
}
