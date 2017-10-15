<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @return mixed
     */
    public function show()
    {
        return Auth::user();
    }
}
