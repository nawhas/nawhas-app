<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Transformers\ReciterTransformer;
use App\Http\Controllers\TransformsResponses;
use Illuminate\Support\Facades\Auth;

class RecitersController extends Controller
{
    use TransformsResponses;

    /**
     * RecitersController constructor.
     * @param ReciterTransformer $transformer
     */
    public function __construct(ReciterTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $query = Reciter::query();

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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $reciter = new Reciter();
        $reciter->name = $request->get('name');
        $reciter->slug = str_slug($reciter->name);
        $reciter->description = $request->get('description');
        if ($request->get('avatar') != "null") {
            $reciter->avatar = $request->get('avatar');
        } else {
            $reciter->avatar = 'https://s3.us-east-2.amazonaws.com/nawhas/defaults/reciter.png';
        }
        $reciter->created_by = Auth::user()->id;
        $reciter->save();

        return $this->respondWithItem(Reciter::find($reciter->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter) : JsonResponse
    {
        $reciter->visit();

        return $this->respondWithItem($reciter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Reciter $reciter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter) : JsonResponse
    {
        $reciter->name = $request->get('name');
        $reciter->slug = str_slug($reciter->name);
        $reciter->description = $request->get('description');
        $reciter->avatar = $request->get('avatar');
        $reciter->created_by = Auth::user()->id;
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
        $reciter->delete();

        return response(null, 204);
    }
}
