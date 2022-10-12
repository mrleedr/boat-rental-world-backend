<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPicture extends Model
{
    use HasFactory;

    protected $table = "trip_picture";
    protected $primaryKey = "trip_picture_id";
    protected $fillable = ["*"];
    public $timestamps = false;
}
