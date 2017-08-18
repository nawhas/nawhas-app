<?php

namespace App\Transformers;

use App\Reciter;
use League\Fractal\TransformerAbstract;

class ReciterTransformer extends TransformerAbstract
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
            'image' => $reciter->image_path,
            'created_at' => $reciter->created_at->toDateString(),
            'updated_at' => $reciter->updated_at->toDateString(),
        ];
    }
}
