<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        return response()->json(
            Tour::with('images','category')->orderByDesc('tourID')->paginate(10)
        );
    }

    public function show($id)
    {
        $tour = Tour::with('images','category')->where('tourID',$id)->firstOrFail();
        return response()->json($tour);
    }
}
