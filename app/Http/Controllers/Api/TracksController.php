<?php

namespace App\Http\Controllers\Api;

use App\Language;
use App\Support\File\ExplicitExtensionFile;
use App\TrackLanguages;
use Auth;
use App\Album;
use App\Track;
use App\Reciter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Transformers\TrackTransformer;
use App\Http\Controllers\TransformsResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class TracksController extends Controller
{
    use TransformsResponses;

    /**
     * TracksController constructor.
     * @param TrackTransformer $transformer
     * @param Filesystem $filesystem
     */
    public function __construct(TrackTransformer $transformer, Filesystem $filesystem)
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
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Reciter $reciter, Album $album) : JsonResponse
    {
        $query = Track::query()
            ->where('reciter_id', $reciter->id)
            ->where('album_id', $album->id);

        if ($request->get('per_page')) {
            $paginate = $query->paginate($request->get('per_page', config('api.pagination.size')));

            return $this->respondWithPaginator($paginate);
        }

        return $this->respondWithCollection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Reciter $reciter, Album $album)
    {
        $audio = $this->upload_audio($request->audio);
        $video = $this->checkIfNull($request->get('video'));

        // storing data into database
        $track = new Track();
        $track->name = $request->get('name');
        $track->slug = str_slug($request->get('name'));
        $track->reciter_id = $reciter->id;
        $track->album_id = $album->id;
        $track->audio = $audio;
        $track->video = $video;
        $track->number = $request->get('number');
        $track->created_by = Auth::user()->id;
        $track->save();

        $languages = explode(',', $request->language);
        foreach ($languages as $language) {
            $language = Language::where('slug', $language)->first();
            $trackLanguage = new TrackLanguages;
            $trackLanguage->track_id = $track->id;
            $trackLanguage->language_id = $language->id;
            $trackLanguage->save();
        }

        return $this->respondWithItem(Track::find($track->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reciter $reciter, Album $album, Track $track) : JsonResponse
    {
        $track->visit();

        return $this->respondWithItem($track);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reciter $reciter, Album $album, Track $track)
    {
        $languages = explode(',', $request->language);
        $deleteTrackLanguage = TrackLanguages::where('track_id', $track->id)->get();
        foreach ($deleteTrackLanguage as $item) {
            $item->delete();
        }

        foreach ($languages as $item) {
            $language = Language::where('slug', $item)->first();
            $trackLanguage = new TrackLanguages;
            $trackLanguage->track_id = $track->id;
            $trackLanguage->language_id = $language->id;
            $trackLanguage->save();
        }

        $updated_audio = $this->checkIfNull($request->updatedAudio);
        if ($updated_audio) {
            $audio = $this->upload_audio($request->updatedAudio);
            $track->audio = $audio;
        }

        $video = $this->checkIfNull($request->get('video'));
        if ($video) {
            $track->video = $video;
        } else {
            $track->video = null;
        }

        $track->name = $request->get('name');
        $track->number = $request->get('number');
        $track->save();

        return $this->respondWithItem(Track::find($track->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reciter $reciter
     * @param Album $album
     * @param Track $track
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Reciter $reciter, Album $album, Track $track)
    {
        $track->delete();

        return response(null, 204);
    }

    public function upload_audio($audioFile)
    {
        if ($audioFile) {
            // Uploading the file
            $file = $audioFile;
            $extension = $file->getClientOriginalName();
            $extension = $this->filesystem->extension($extension);
            $md5 = $this->filesystem->hash($file);
            $filename = $md5 . '.' . $extension;
            $path = "tracks/$filename";
            if (Storage::exists($path)) {
                $audio = Storage::url($path);
            } else {
                $uploadedFilePath = Storage::putFileAs('tracks', new ExplicitExtensionFile($file), $filename, 'public');
                $audio = Storage::url($uploadedFilePath);
            }

            return $audio;
        } else {
            return null;
        }
    }

    public function checkIfNull($variable)
    {
        if ($variable === 'null' or null or "undefined") {
            return null;
        } else {
            return $variable;
        }
    }
}
