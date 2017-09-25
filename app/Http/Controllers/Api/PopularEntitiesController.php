<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Http\Controllers\TransformsResponses;
use App\Reciter;
use App\Scopes\DefaultSortScope;
use App\Track;
use App\Transformers\AlbumTransformer;
use App\Transformers\ReciterTransformer;
use App\Transformers\TrackTransformer;
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

        $reciters = Reciter::query()
            ->withoutGlobalScope(DefaultSortScope::class)
            ->popularLast($period)->limit($limit)
            ->get();

        return $this->respondWithCollection($reciters, $transformer);
    }

    public function albums(Request $request, AlbumTransformer $transformer)
    {
        $period = $request->get('period', 30);
        $limit = $request->get('limit', 10);

        $albums = Album::query()
            ->withoutGlobalScope(DefaultSortScope::class)
            ->popularLast($period)->limit($limit)->get();

        return $this->respondWithCollection($albums, $transformer);
    }

    public function tracks(Request $request, TrackTransformer $transformer)
    {
        $period = $request->get('period', 30);
        $limit = $request->get('limit', 10);

        $query = Track::query()
            ->withoutGlobalScope(DefaultSortScope::class);

        $query->popularLast($period)
            ->limit($limit);

        if ($request->get('reciterId')) {
            $query->where('reciter_id', $request->get('reciterId'));
        }

        return $this->respondWithCollection($query->get(), $transformer);
    }
}
