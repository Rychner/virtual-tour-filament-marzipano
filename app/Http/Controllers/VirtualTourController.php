<?php

namespace App\Http\Controllers;

use App\Models\Panorama;
use App\Models\Room;

class VirtualTourController extends Controller
{
    public function index()
    {
        $panoramas = Panorama::with('hotspots')->get();

        $rooms = Room::with('panorama')->get()->groupBy('category');

        return view('virtualtour', compact('panoramas', 'rooms'));
    }

    public function show($slug)
    {
        $panoramas = Panorama::with('hotspots')->get();

        $currentPanorama = Panorama::with('hotspots')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('virtual-tour', [
            'panoramas' => $panoramas,
            'currentPanorama' => $currentPanorama,
        ]);
    }
}
