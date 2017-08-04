<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Reciter $reciter)
    {
        $album = Album::where('reciter_id', $reciter->id)->get();

        return $album;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reciter $reciter)
    {
        $album = new Album;
        $album->name = $request->get('name');
        $album->reciter_id = $reciter->id;
        $album->year = $request->get('year');
        $album->hits = 1;
        $album->image_path = $request->get('image_path');
        $album->created_by = 1;
        $album->save();

        return Album::find($album->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reciter $reciter, Album $album)
    {
        return $album;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reciter $reciter, Album $album)
    {
        $album->name = $request->get('name');
        $album->year = $request->get('year');
        $album->hits = 1;
        $album->image_path = $request->get('image_path');
        $album->created_by = 1;
        $album->save();

        return Album::find($album->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter, Album $album)
    {
        $album->destroy($album->id);

        return response(null, 204);
    }
}
