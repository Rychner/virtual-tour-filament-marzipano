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
}
