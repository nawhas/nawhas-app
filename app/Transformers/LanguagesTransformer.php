<?php

namespace App\Transformers;

use App\Language;

class LanguagesTransformer extends Transformer
{
    /**
     * @param Language $language
     * @return array
     * @internal param Track $track
     */
    public function transform(Language $language)
    {
        return [
            'name' => $language->name,
            'slug' => $language->slug,
        ];
    }
}
