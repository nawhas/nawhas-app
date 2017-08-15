<?php

namespace App\Transformers;

use App\Track;
use League\Fractal\TransformerAbstract;

class TracksTransformer extends TransformerAbstract
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
            'file' => $track->file_path,
            'link' => $track->mp3_link,
            'track_number' => $track->track_number,
            'language' => $track->language,
            'created_at' => $track->created_at->toDateString(),
            'updated_at' => $track->updated_at->toDateString(),
        ];
    }
}
