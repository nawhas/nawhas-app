<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\RecitersTransformer;
use App\Http\Controllers\TransformsResponses;

class RecitersController extends Controller
{
    use TransformsResponses;

    /**
     * RecitersController constructor.
     * @param RecitersTransformer $transformer
     */
    public function __construct(RecitersTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reciters = Reciter::all();

        return $this->respondWithCollection($reciters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reciter = new Reciter();
        $reciter->name = $request->get('name');
        $reciter->slug = str_slug($reciter->name);
        $reciter->description = $request->get('description');
        $reciter->hits = 1;
        $reciter->image_path = $request->get('image_path');
        $reciter->created_by = 1;
        $reciter->save();

        return $this->respondWithItem(Reciter::find($reciter->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reciter $reciter)
    {
        return $this->respondWithItem($reciter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Reciter $reciter
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reciter $reciter)
    {
        $reciter->name = $request->get('name');
        $reciter->slug = str_slug($reciter->name);
        $reciter->description = $request->get('description');
        $reciter->hits = 1;
        $reciter->image_path = $request->get('image_path');
        $reciter->created_by = 1;
        $reciter->save();

        return $this->respondWithItem(Reciter::find($reciter->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reciter $reciter
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter)
    {
        $reciter->destroy($reciter->id);

        return response(null, 204);
    }
}
