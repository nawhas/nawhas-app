<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class popularController extends Controller
{
    static function reciters(Request $request)
    {
        if ($request->get('period')) {
            $period = $request->get('period');
        } else {
            $period = 30;
        }
        return Reciter::popularLast($period)->get();
    }
}
