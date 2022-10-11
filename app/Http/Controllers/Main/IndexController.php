<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $markers = Marker::all();
        return view('main.index', compact('markers'));
    }
}
