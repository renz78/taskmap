<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marker\StoreRequest;
use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        $markers = Marker::all();
        return 1;
        //return view('markers.index', 'markers');
    }

    public function store(StoreRequest $request )
    {
        $data = $request->validated();
        //print_r($data);
        Marker::create($data);
        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }
}
