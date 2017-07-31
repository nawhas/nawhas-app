<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reciter;

class RecitersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reciters = Reciter::all();
        return $reciters;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reciter = new Reciter;
        $reciter->name = $request->name;
        $reciter->slug = $request->slug;
        $reciter->description = $request->description;
        $reciter->hits = 1;
        $reciter->image_path = "Hello";
        $reciter->created_by = 1;
        $reciter->save();

        return $reciter;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reciter $reciter)
    {
        return $reciter;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reciter $reciter)
    {
        $reciter->name = $request->name;
        $reciter->slug = $request->slug;
        $reciter->description = $request->description;
        $reciter->hits = 1;
        $reciter->image_path = "Hello";
        $reciter->created_by = 1;
        $reciter->save();

        return $reciter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter)
    {
        $reciter->destroy($reciter->id);
    }
}
