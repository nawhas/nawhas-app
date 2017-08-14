<?php

namespace App\Transformers;

use App\Reciter;
use League\Fractal\TransformerAbstract;

class RecitersTransformer extends TransformerAbstract
{
    public function transform(Reciter $reciter)
    {
        return [
            'id' => $reciter->id,
            'name' => $reciter->name,
            'image' => $reciter->image_path,
            'created_at' => $reciter->created_at->format('l jS \\of F Y h:i:s A'),
        ];
    }
}
