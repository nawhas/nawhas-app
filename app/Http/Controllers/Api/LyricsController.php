<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Lyric;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LyricsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Reciter $reciter, Album $album, Track $track)
    {
        $lyric = $track->lyrics()->first();

        return $lyric;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        return Lyric::find($lyric->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        return $lyric;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        $lyric->text = $request->get('text');
        $lyric->language = $request->get('language');
        $lyric->save();

        return Lyric::find($lyric->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter, Album $album, Track $track, Lyric $lyric)
    {
        $lyric->destroy($lyric->id);

        return response(null, 204);
    }
}
