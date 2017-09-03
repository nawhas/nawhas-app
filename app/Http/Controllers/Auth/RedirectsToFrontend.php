<?php

namespace App\Http\Controllers\Auth;

use Request;

trait RedirectsToFrontend
{
    protected function redirectTo()
    {
        $redirect = Request::get('redirect');

        // TODO - Secure redirects by checking hostname

        if (!$redirect) {
            return env('FRONTEND_URL') . '/auth/redirect';
        }

        return $redirect;
    }
}
