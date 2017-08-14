<?php

namespace App\Transformers;

use App\Reciter;
use League\Fractal\TransformerAbstract;

class RecitersTransformer extends TransformerAbstract
{
    /**
     * @param Reciter $reciter
     * @return array
     */
    public function transform(Reciter $reciter)
    {
        $name = explode(" ", $reciter->name);
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $i = 0;
        $len = count($name);
        foreach ($name as $item) {
            if ($i == 0) {
                $first_name .= $item;
            } else if ($i == $len - 1) {
                $last_name .= $item;
            } else {
                $middle_name .= $item . ' ';
            }
            $i++;
        }
        return [
            'id' => $reciter->id,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'slug' => $reciter->slug,
            'image' => $reciter->image_path,
            'created_at' => $reciter->created_at->format('l jS \\of F Y h:i:s A'),
        ];
    }
}
