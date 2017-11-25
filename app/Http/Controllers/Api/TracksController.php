<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Album;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Transformers\TrackTransformer;
use App\Http\Controllers\TransformsResponses;

class TracksController extends Controller
{
    use TransformsResponses;

    /**
     * TracksController constructor.
     * @param TrackTransformer $transformer
     */
    public function __construct(TrackTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Reciter $reciter, Album $album) : JsonResponse
    {
        $query = Track::query()
            ->where('reciter_id', $reciter)
            ->where('album_id', $album->id);

        if ($request->get('per_page')) {
            $paginate = $query->paginate($request->get('per_page', config('api.pagination.size')));

            return $this->respondWithPaginator($paginate);
        }

        return $this->respondWithCollection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Reciter $reciter, Album $album) : JsonResponse
    {
        $track = new Track();
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->album_id = $album->id;
        $track->video = $request->get('video');
        $track->audio = $request->get('audio');
        $track->number = $request->get('number');
        $track->language = 'en';
        $track->created_by = Auth::user()->id;
        $track->save();

        return $this->respondWithItem(Track::find($track->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter, Album $album, Track $track) : JsonResponse
    {
        $track->visit();

        return $this->respondWithItem($track);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track) : JsonResponse
    {
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->video = $request->get('video');
        $track->audio = $request->get('audio');
        $track->number = $request->get('number');
        $track->language = 'en';
        $track->save();

        return $this->respondWithItem(Track::find($track->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter, Album $album, Track $track)
    {
        $track->delete();

        return response(null, 204);
    }
}
