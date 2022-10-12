<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $markers = Marker::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-1 minutes')))->get();
        return view('main.index', compact('markers'));
    }
}
