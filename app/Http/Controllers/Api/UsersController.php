<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\TransformsResponses;
use App\Transformers\UsersTransformer;
use Auth;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    use TransformsResponses;

    /**
     * UsersController constructor.
     * @param UsersTransformer $transformer
     */
    public function __construct(UsersTransformer $transformer)
    {
        $this->middleware('auth:api');
        $this->transformer = $transformer;
    }
    /**
     * @return mixed
     */
    public function show()
    {
        return $this->respondWithItem(Auth::user());
    }
}
