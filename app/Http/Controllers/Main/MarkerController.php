<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marker\StoreRequest;
use App\Models\Marker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        $markers = Marker::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-1 minutes')))->get();
        return $markers->toJson();
    }

    public function store(StoreRequest $request )
    {
        $data = $request->validated();
        Marker::create($data);
        return response()->json(['success'=>'Новий маркер додано!']);
    }
}
