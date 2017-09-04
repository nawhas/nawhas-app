<?php

namespace App\Transformers;

use App\Track;
use League\Fractal\TransformerAbstract;

class TrackTransformer extends TransformerAbstract
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
            'file_path' => $track->file_path,
            'mp3_link' => $track->mp3_link,
            'track_number' => $track->track_number,
            'language' => $track->language,
            'created_at' => $track->created_at->toDateTimeString(),
            'updated_at' => $track->updated_at->toDateTimeString(),
        ];
    }
}