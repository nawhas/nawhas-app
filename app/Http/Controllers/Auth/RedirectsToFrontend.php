<?php

namespace App\Http\Controllers\Auth;

use Request;

trait RedirectsToFrontend
{
    protected function redirectTo()
    {
        return '/';
    }
}
