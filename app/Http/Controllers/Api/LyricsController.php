<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Album;
use App\Lyric;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Reciter $reciter, Album $album, Track $track) : JsonResponse
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Reciter $reciter, Album $album, Track $track)
    {
        $native_language = $request->get('native_language');
        if ($native_language === 'true') {
            $native_language = true;
        } else {
            $native_language = false;
        }
        $lyric = new Lyric();
        $lyric->track_id = $track->id;
        $lyric->text = $request->get('text');
        $lyric->native_language = $native_language;
        $lyric->created_by = Auth::user()->id;
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter, Album $album, Track $track, Lyric $lyric) : JsonResponse
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track, Lyric $lyric) : JsonResponse
    {
        $lyric->text = $request->get('text');
        //$lyric->native_language = $request->get('native_language');
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
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        $lyric->delete();

        return response(null, 204);
    }
}
