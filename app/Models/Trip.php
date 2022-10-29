<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = "trip";
    protected $primaryKey  = "trip_id";

    protected  $fillable = [
        'head_line', 'description', 'trip_status', 'operator_status', 'operator_status'
    ];

    public function pictures(){
        return $this->join('trip_link_trip_picture', 'trip.trip_id', 'trip_link_trip_picture.trip_id')
                    ->join('trip_picture', 'trip_link_trip_picture.trip_picture_id', 'trip_picture.trip_picture_id')
                    ->select('trip_picture.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->get()->toArray();
    }

    public function vessel(){
        return $this->join('trip_link_vessel', 'trip.trip_id', 'trip_link_vessel.trip_id')
                    ->join('vessel', 'trip_link_vessel.vessel_id', 'vessel.vessel_id')
                    ->select('vessel.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first()->toArray();
    }

    public function vessel_features(){
        return $this->join('trip_link_vessel', 'trip.trip_id', 'trip_link_vessel.trip_id')
                    ->join('vessel', 'trip_link_vessel.vessel_id', 'vessel.vessel_id')
                    ->join('vessel_link_feature','vessel.vessel_id', 'vessel_link_feature.vessel_id')
                    ->join('feature', 'vessel_link_feature.feature_id', 'feature.feature_id')
                    ->select('feature.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->get()->toArray();
    }
    
    public function categories(){
        return $this->join('trip_link_trip_category', 'trip.trip_id', 'trip_link_trip_category.trip_id')
                    ->join('trip_category', 'trip_link_trip_category.trip_category_id', 'trip_category.trip_category_id')
                    ->select('trip_category.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->get()->toArray();
    }

    public function location(){
        return $this->join('trip_link_location', 'trip.trip_id', 'trip_link_location.trip_id')
                    ->join('location', 'trip_link_location.location_id', 'location.location_id')
                    ->select('location.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first()->toArray();
    }

    public function pricing(){
        return $this->join('trip_link_pricing', 'trip.trip_id', 'trip_link_pricing.trip_id')
                    ->join('pricing', 'trip_link_pricing.pricing_id', 'pricing.pricing_id')
                    ->select('pricing.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first();
    }

    public function addons(){
        return $this->join('trip_link_trip_addon', 'trip.trip_id', 'trip_link_trip_addon.trip_id')
                    ->join('trip_addon', 'trip_link_trip_addon.trip_addon_id', 'trip_addon.trip_addon_id')
                    ->select('trip_addon.*')
                    ->where('trip.trip_id', $this->trip_id)
                    ->get()->toArray();
    }

    public function user(){
        return $this->join('user_link_trip', 'trip.trip_id', 'user_link_trip.trip_id')
                    ->join('users', 'user_link_trip.user_id', 'users.user_id')
                    ->select('users.user_id','users.email', 'users.first_name', 'users.last_name')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first()->toArray();
    }

    public function trip_status(){
        return $this->join('trip_status', 'trip.trip_status_id', 'trip_status.trip_status_id')
                    ->select('trip_status.trip_status_id', 'trip_status.description')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first()->toArray();
    }

    public function operator_status(){
        return $this->join('operator_status', 'trip.operator_status_id', 'operator_status.operator_status_id')
                    ->select('operator_status.operator_status_id', 'operator_status.description')
                    ->where('trip.trip_id', $this->trip_id)
                    ->first()->toArray();
    }

}