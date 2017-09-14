<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use App\Transformers\ReciterTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class popularController extends Controller
{
    public function reciters(Request $request, ReciterTransformer $transformer)
    {
        $this->transformer = $transformer;
        if ($request->get('period')) {
            $period = $request->get('period');
        } else {
            $period = 30;
        }

        return Reciter::popularLast($period)->get();
    }
}
