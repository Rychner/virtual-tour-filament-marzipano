<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'panorama_id',
        'hotspot_id',
    ];

    // Hotspot milik panorama asal
    public function panorama()
    {
        return $this->belongsTo(Panorama::class);
    }

    // Hotspot milik panorama asal
    public function hotspot()
    {
        return $this->belongsTo(Hotspot::class);
    }
}
