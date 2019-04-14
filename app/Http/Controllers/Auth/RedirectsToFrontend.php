<?php

namespace App\Http\Controllers\Auth;

trait RedirectsToFrontend
{
    protected function redirectTo()
    {
        return '/';
    }
}
