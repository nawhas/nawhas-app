<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Lyric;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\LyricTransformer;
use App\Http\Controllers\TransformsResponses;

class LyricsController extends Controller
{
    use TransformsResponses;

    /**
     * LyricsController constructor.
     * @param LyricTransformer $transformer
     */
    public function __construct(LyricTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @return \Illuminate\Http\Response
     */
    public function index(Reciter $reciter, Album $album, Track $track)
    {
        $lyric = $track->lyrics()->first();

        return $this->respondWithItem($lyric);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reciter $reciter, Album $album, Track $track)
    {
        $lyric = new Lyric;
        $lyric->track_id = $track->id;
        $lyric->text = $request->get('text');
        $lyric->language = $request->get('language');
        $lyric->created_by = 1;
        $lyric->save();

        return $this->respondWithItem(Lyric::find($lyric->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @param Lyric $lyric
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        return $this->respondWithItem($lyric);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @param Lyric $lyric
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        $lyric->text = $request->get('text');
        $lyric->language = $request->get('language');
        $lyric->save();

        return $this->respondWithItem(Lyric::find($lyric->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     * @param Lyric $lyric
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        $lyric->destroy($lyric->id);

        return response(null, 204);
    }
}
