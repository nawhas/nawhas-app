<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\TransformsResponses;
use App\Language;
use App\Transformers\LanguagesTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    use TransformsResponses;
    /**
     * AlbumsController constructor.
     * @param LanguagesTransformer $transformer
     */
    public function __construct(LanguagesTransformer $transformer)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
    }

    public function index()
    {
        $query = Language::query();
        return $this->respondWithCollection($query->get());
    }

    public function store(Request $request)
    {
    }

    public function show()
    {
    }

    public function update(Request $request)
    {
    }
}
