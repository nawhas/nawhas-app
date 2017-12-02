<?php

namespace App\Http\Controllers\Api;

use App\Support\File\ExplicitExtensionFile;
use Auth;
use App\Album;
use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use App\Transformers\AlbumTransformer;
use App\Http\Controllers\TransformsResponses;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    use TransformsResponses;

    /**
     * AlbumsController constructor.
     * @param AlbumTransformer $transformer
     */
    public function __construct(AlbumTransformer $transformer, Filesystem $filesystem)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->transformer = $transformer;
        $this->filesystem = $filesystem;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Reciter $reciter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Reciter $reciter) : JsonResponse
    {
        $query = Album::query()->with(['reciter', 'tracks'])
            ->where('reciter_id', $reciter->id);

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
     * @param Reciter $reciter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Reciter $reciter) : JsonResponse
    {
        if ($request->artwork) {
            $file = $request->artwork;
            $extension = $this->filesystem->extension($file);
            $md5 = $this->filesystem->hash($file);
            $filename = $md5 . '.' . $extension;
            $path = 'albums' . '/' . $filename;
            if (Storage::exists($path)) {
                $imageURL = Storage::url($path);
            } else{
                $uploadedFilePath = Storage::putFileAs('reciters', new ExplicitExtensionFile($file), $filename, 'public');
                $imageURL = Storage::url($uploadedFilePath);
            }
        }
        $album = new Album();
        $album->name = $request->get('name');
        $album->reciter_id = $reciter->id;
        $album->year = $request->get('year');
        $album->artwork = $imageURL;
        $album->created_by = Auth::user()->id;
        $album->save();

        return $this->respondWithItem(Album::find($album->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter, Album $album) : JsonResponse
    {
        $album->visit();

        return $this->respondWithItem($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter, Album $album) : JsonResponse
    {
        if ($request->updatedArtwork) {
            $file = $request->updatedArtwork;
            $extension = $this->filesystem->extension($file);
            $md5 = $this->filesystem->hash($file);
            $filename = $md5 . '.' . $extension;
            $path = 'albums' . '/' . $filename;
            if (Storage::exists($path)) {
                $imageURL = Storage::url($path);
            } else{
                $uploadedFilePath = Storage::putFileAs('reciters', new ExplicitExtensionFile($file), $filename, 'public');
                $imageURL = Storage::url($uploadedFilePath);
            }
            $album->artwork = $imageURL;
        }
        $album->name = $request->get('name');
        $album->save();

        return $this->respondWithItem(Album::find($album->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reciter $reciter, Album $album)
    {
        $album->delete();

        return response(null, 204);
    }
}
