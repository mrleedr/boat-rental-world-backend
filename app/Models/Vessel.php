<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    protected $table = "vessel";
    protected $primaryKey = "vessel_id";
    protected $fillable = ["*"];
    public $timestamps = false;
}
