<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyImage extends Model
{
    use HasFactory;
    protected $table = "property_images";

    protected $fillable = [
        "property_id",
        "image_url"
    ];
}
