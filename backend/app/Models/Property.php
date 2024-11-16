<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "title",
        "description",
        "type",
        "price",
        "location",
        "surface_area",
        "rooms",
        "status",
    ];
    public function images(){
        return $this->hasMany(PropertyImage::class);
    }
    public function owner(){
        return $this->BelongsTo(User::class);
    }
}