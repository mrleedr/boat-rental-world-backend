<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "booking";
    protected $primaryKey = "booking_id";
    protected $fillable = ["*"];
    
    public function operator_status(){
        return $this->join('operator_status', 'booking.operator_status_id', 'operator_status.operator_status_id')
                    ->select('operator_status.operator_status_id', 'operator_status.description')
                    ->where('booking.booking_id', $this->booking_id)
                    ->first()->toArray();
    }

    public function booking_status(){
        return $this->join('booking_status', 'booking.booking_status_id', 'booking_status.booking_status_id')
                    ->select('booking_status.booking_status_id', 'booking_status.description')
                    ->where('booking.booking_id', $this->booking_id)
                    ->first()->toArray();
        }

    public function client(){
        return $this->join('user_link_booking', 'booking.booking_id', 'user_link_booking.booking_id')
                    ->join('users', 'user_link_booking.user_id', 'users.user_id')
                    ->select('users.user_id','users.email', 'users.first_name', 'users.last_name')
                    ->where('booking.booking_id', $this->booking_id)
                    ->first()->toArray();
    }
    

    public function alternative_dates(){
        return $this->join('booking_link_booking_alternative_date', 'booking.booking_id', 'booking_link_booking_alternative_date.booking_id')
                    ->join('booking_alternative_date', 'booking_link_booking_alternative_date.booking_alternative_date_id','booking_alternative_date.booking_alternative_date_id')
                    ->select('booking_alternative_date.*')
                    ->where('booking.booking_id', $this->booking_id)
                    ->get()->toArray();
    }

    public function booking_addons(){
        return $this->join('booking_link_booking_addon', 'booking.booking_id', 'booking_link_booking_addon.booking_id')
                    ->join('booking_addon', 'booking_link_booking_addon.booking_addon_id','booking_addon.booking_addon_id')
                    ->select('booking_addon.*')
                    ->where('booking.booking_id', $this->booking_id)
                    ->get()->toArray();
    }

    public function trip_owner(){
        return $this->join('trip_link_booking', 'trip_link_booking.booking_id', 'booking.booking_id')
                    ->join('user_link_trip', 'trip_link_booking.trip_id', 'user_link_trip.trip_id')
                    ->join('users', 'user_link_trip.user_id', 'users.user_id')
                    ->select('users.user_id','users.email', 'users.first_name', 'users.last_name')
                    ->where('booking.booking_id', $this->booking_id)
                    ->first()->toArray();
    }

}
