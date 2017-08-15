<?php

namespace App\Transformers;

use App\Lyric;
use League\Fractal\TransformerAbstract;

class LyricsTransformer extends TransformerAbstract
{
    /**
     * @param Lyric $lyric
     * @return array
     */
    public function transform(Lyric $lyric)
    {
        return [
            'id' => $lyric->id,
            'track_id' => $lyric->track_id,
            'text' => $lyric->text,
            'language' => $lyric->language,
            'created_at' => $lyric->created_at->toDateString(),
            'updated_at' => $lyric->updated_at->toDateString(),
        ];
    }
}
