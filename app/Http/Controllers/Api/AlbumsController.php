<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Transformers\AlbumTransformer;
use App\Http\Controllers\TransformsResponses;

class AlbumsController extends Controller
{
    use TransformsResponses;

    /**
     * AlbumsController constructor.
     * @param AlbumTransformer $transformer
     */
    public function __construct(AlbumTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Reciter $reciter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Reciter $reciter) : JsonResponse
    {
        $query = Album::query()->where('reciter_id', $reciter->id);

        if ($request->get('per_page')) {
            $paginate = $query->paginate(
                $request->get('per_page', config('api.pagination.size'))
            );

            return $this->respondWithPaginator($paginate);
        }

        return $this->respondWithCollection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Reciter $reciter) : JsonResponse
    {
        $album = new Album();
        $album->name = $request->get('name');
        $album->reciter_id = $reciter->id;
        $album->year = $request->get('year');
        $album->hits = 1;
        $album->image_path = $request->get('image_path');
        $album->created_by = 1;
        $album->save();

        return $this->respondWithItem(Album::find($album->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter, Album $album) : JsonResponse
    {
        return $this->respondWithItem($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter, Album $album) : JsonResponse
    {
        $album->name = $request->get('name');
        $album->year = $request->get('year');
        $album->hits = 1;
        $album->image_path = $request->get('image_path');
        $album->created_by = 1;
        $album->save();

        return $this->respondWithItem(Album::find($album->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter, Album $album)
    {
        $album->delete();

        return response(null, 204);
    }
}
