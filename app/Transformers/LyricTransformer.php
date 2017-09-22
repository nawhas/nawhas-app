<?php

namespace App\Transformers;

use App\Lyric;

class LyricTransformer extends Transformer
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
            'created_by' => $lyric->created_by,
            'created_at' => $lyric->created_at->toDateTimeString(),
            'updated_at' => $lyric->updated_at->toDateTimeString(),
        ];
    }
}
