<?php

namespace App\Transformers;

use App\Lyric;

class LyricTransformer extends Transformer
{
    /**
     * @param Lyric $lyric
     * @return array
     * @internal param Track $track
     *
     */
    public function transform(Lyric $lyric)
    {
        return [
            'id' => $lyric->id,
            'text' => $lyric->text,
            'track_id' => $lyric->track_id,
            'created_at' => $lyric->created_at->toDateTimeString(),
            'updated_at' => $lyric->updated_at->toDateTimeString(),
        ];
    }
}
