<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use App\Album;
use App\Track;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TracksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Reciter $reciter, Album $album)
    {
        $tracks = Track::where('album_id', $album->id)->get();

        return $tracks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reciter $reciter, Album $album) {
        $track = new Track;
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->album_id = $album->id;
        $track->mp3_link = $request->get('mp3_link');
        $track->file_path =$request->get('file_path');
        $track->hits = 1;
        $track->track_number = $request->get('track_number');
        $track->language = 'English';
        $track->created_by = 1;
        $track->save();

        return Track::find($track->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reciter $reciter, Album $album, Track $track)
    {
        return $track;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
