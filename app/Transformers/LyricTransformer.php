<?php

namespace App\Transformers;

use App\Lyric;

class LyricTransformer extends Transformer
{
    /**
     * @param Lyric $lyric
     * @return array
     * @internal param Track $track
     */
    public function transform(Lyric $lyric)
    {
        $lyricText = $lyric->text;
        if ($lyricText === "null") {
            $lyricText = null;
        }
        if ($lyric->native_language) {
            $lyricTitle = 'Native Language';
        } else {
            $lyricTitle = 'Roman English';
        }
        return [
            'id' => $lyric->id,
            'title' => $lyricTitle,
            'text' => $lyric->text ? nl2br($lyricText) : null,
            'plain_text' => $lyric->text,
            'track_id' => $lyric->track_id,
            'created_at' => $lyric->created_at->toDateTimeString(),
            'updated_at' => $lyric->updated_at->toDateTimeString(),
        ];
    }
}
