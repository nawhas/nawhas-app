<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\TransformsResponses;
use App\Reciter;
use App\Transformers\ReciterTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PopularEntitiesController extends Controller
{
    use TransformsResponses;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Transformers\ReciterTransformer $transformer
     *
     * @return mixed
     */
    public function reciters(Request $request, ReciterTransformer $transformer)
    {
        $period = $request->get('period', 30);
        $limit = $request->get('limit', 10);

        $reciters = Reciter::query()->popularLast($period)->limit($limit)->get();

        return $this->respondWithCollection($reciters, $transformer);
    }
}
