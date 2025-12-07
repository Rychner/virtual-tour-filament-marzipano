<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'panorama_id',
        'yaw',
        'pitch',
        'type',
        'label',
        'target_panorama_id',
        'icon_path',
    ];

    protected $casts = [
        'yaw' => 'float',
        'pitch' => 'float',
    ];

    // Hotspot milik panorama asal
    public function panorama()
    {
        return $this->belongsTo(Panorama::class);
    }

    // Hotspot mengarah ke panorama target
    public function target()
    {
        return $this->belongsTo(Panorama::class, 'target_panorama_id');
    }
}
