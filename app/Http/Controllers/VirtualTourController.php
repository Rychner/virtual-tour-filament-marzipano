<?php

namespace App\Http\Controllers;

use App\Models\Panorama;

class VirtualTourController extends Controller
{
    public function index()
    {
        $panoramas = Panorama::with('hotspots')->get();
        return view('virtualtour', compact('panoramas'));
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
