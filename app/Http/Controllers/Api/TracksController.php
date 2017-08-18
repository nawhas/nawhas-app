<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Reciter $reciter, Album $album)
    {
        $query = Track::query()
            ->where('album_id', $album->id);

        if ($request->get('per_page')) {
            $paginate = $query->paginate($request->get('per_page', 10));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reciter $reciter, Album $album)
    {
        $track = new Track;
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->album_id = $album->id;
        $track->mp3_link = $request->get('mp3_link');
        $track->file_path = $request->get('file_path');
        $track->hits = 1;
        $track->track_number = $request->get('track_number');
        $track->language = 'en';
        $track->created_by = 1;
        $track->save();

        return $this->respondWithItem(Track::find($track->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Reciter $reciter, Album $album, Track $track)
    {
        return $this->respondWithItem($track);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track)
    {
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->mp3_link = $request->get('mp3_link');
        $track->file_path = $request->get('file_path');
        $track->track_number = $request->get('track_number');
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
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Reciter $reciter, Album $album, Track $track)
    {
        $track->destroy($track->id);

        return response(null, 204);
    }
}
