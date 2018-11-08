<?php

namespace App\Providers;

use App\Album;
use App\Reciter;
use App\Track;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('reciter', function ($value) {
            return Reciter::where('id', $value)->orWhere('slug', $value)->firstOrFail();
        });

        Route::bind('album', function ($value, $route) {
            if ($reciter = $route->parameter('reciter')) {
                return Album::where('reciter_id', $reciter->id)->where('year', $value)->firstOrFail();
            } else {
                throw new ModelNotFoundException();
            }
        });

        Route::bind('track', function ($value, $route) {
            if ($reciter = $route->parameter('reciter')) {
                if ($album = $route->parameter('album')) {
                    return $reciter->albums()->where('id', $album->id)->firstOrFail()->tracks()->where('slug', $value)->orWhere('id', $value)->orWhere('number', $value)->firstOrFail();
                } else {
                    throw new ModelNotFoundException();
                }
            } else {
                throw new ModelNotFoundException();
            }
        });

        Route::bind('lyric', function ($value, $route) {
            if ($track = $route->parameter('track')) {
                return $track->lyrics()->where('id', $value)->firstOrFail();
            } else {
                throw new ModelNotFoundException();
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
