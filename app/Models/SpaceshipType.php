<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceshipType extends Model
{
    protected $casts = [
        "brands" => "array"
    ];
}
