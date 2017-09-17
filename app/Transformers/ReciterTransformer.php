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
            'avatar' => $reciter->avatar,
            'description' => $reciter->description,
            'created_by' => $reciter->created_by,
            'created_at' => $reciter->created_at->toDateTimeString(),
            'updated_at' => $reciter->updated_at->toDateTimeString(),
        ];
    }
}
