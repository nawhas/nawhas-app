<?php

namespace App\Http\Controllers;

use App\Transformers\Transformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

trait TransformsResponses
{
    /**
     * @var Transformer
     */
    protected $transformer;

    /**
     * @param $item
     * @param \App\Transformers\Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, Transformer $transformer = null) : JsonResponse
    {
        $transformer = $transformer ?: $this->transformer;
        $resource = new FractalItem($item, $transformer);
        $rootScope = app(FractalManager::class)->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param array $array
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithArray(array $array, array $headers = []) : JsonResponse
    {
        $response = response()->json($array, 200, $headers);

        return $response;
    }

    /**
     * @param $collection
     * @param \App\Transformers\Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection, Transformer $transformer = null) : JsonResponse
    {
        $transformer = $transformer ?: $this->transformer;
        $resource = new FractalCollection($collection, $transformer);
        $rootScope = app(FractalManager::class)->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param Paginator $paginator
     * @param Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithPaginator(Paginator $paginator, Transformer $transformer = null) : JsonResponse
    {
        $collection = $paginator->getCollection();

        $transformer = $transformer ?: $this->transformer;
        $resource = new FractalCollection($collection, $transformer);

        // Append all other query params to the paginator.
        $paginator->appends(request()->except('page'));
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope = app(FractalManager::class)->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }
}
