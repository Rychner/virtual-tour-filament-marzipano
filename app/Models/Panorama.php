<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panorama extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image_path',
        'description',
        'initial_yaw',
        'initial_pitch',
        'initial_fov',
    ];

    protected $casts = [
        'initial_yaw' => 'float',
        'initial_pitch' => 'float',
        'initial_fov' => 'float',
    ];

    // Panorama memiliki banyak hotspot
    public function hotspots()
    {
        return $this->hasMany(Hotspot::class);
    }

    // Panorama bisa menjadi target panorama dari banyak hotspot
    public function incomingHotspots()
    {
        return $this->hasMany(Hotspot::class, 'target_panorama_id');
    }
}
