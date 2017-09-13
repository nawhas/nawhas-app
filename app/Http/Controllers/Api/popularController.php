<?php

namespace App\Http\Controllers\Api;

use App\Reciter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class popularController extends Controller
{
    static function reciters()
    {
        if (isset($_GET['period'])){
            $period = $_GET['period'];
        } else {
            $period = 3;
        }
        return Reciter::popularLast($period)->get();
    }
}
