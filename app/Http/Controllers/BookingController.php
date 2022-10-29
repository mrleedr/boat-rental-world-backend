<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\InquiryRequest;
use App\Models\Booking;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookingController extends Controller
{
    use HttpResponses;

         /**
     * Show the details of a tour
     *
     * @return \Illuminate\Http\Response
     */
    public function createInquiry(InquiryRequest $request)
    {
        $user = Auth::user();
        $alternative_dates = (object) $request->alternative_dates;
        $booking_addons = (object) $request->booking_addons;

        $inquiry = new Booking;
        $inquiry->operator_status = $request->operator_status;
        $inquiry->duration_hour = $request->duration_hour;
        $inquiry->duration_minutes = $request->duration_minutes;
        $inquiry->overnight = $request->overnight;
        $inquiry->preferred_date = $request->preferred_date;
        $inquiry->return_date = $request->return_date;
        $inquiry->pick_up_time = $request->pick_up_time;
        $inquiry->drop_off_time = $request->drop_off_time;
        $inquiry->no_of_guest = $request->no_of_guest;
        $inquiry->user_id = $user->user_id;
        $inquiry->other_request = $user->other_request;
        $inquiry->booking_status_id = 1; // New Inquiry
        $inquiry->save();

        /* save the alternative dates */
        if(!empty($alternative_dates)){
            foreach($alternative_dates as $item){
                $alternative_date = (object) $item;

                /* save the alternative date first */
                $alternative_date_id = DB::table('booking_alternative_date')->insertGetId(
                    [
                        'preferred_date'=> $alternative_date->preferred_date, 
                        'return_date' => $alternative_date->return_date
                    ]
                );

                /* link it to booking */
                DB::table('booking_link_booking_alternative_date')->insertGetId(
                    [
                        'booking_id'=> $inquiry->booking_id, 
                        'booking_alternative_date_id' => $alternative_date_id,
                    ]
                );
            }
        }

        /* Save booking addons if there is any */
        if(!empty($booking_addons)){
            foreach($booking_addons as $item){
                $booking_addon = (object) $item;
                /* save the booking addon first */
                $booking_addon_id = DB::table('booking_addon')->insertGetId(
                    ['trip_addon_id'=> $booking_addon->trip_addon_id, 'other_request' => $booking_addon->other_request],                
                );   

                 /* link it to booking */
                 DB::table('booking_link_booking_addon')->insertGetId(
                    [
                        'booking_id'=> $inquiry->booking_id, 
                        'booking_addon_id' => $booking_addon_id,
                    ]
                );
            }
        }

        /* Link booking to tour */
        DB::table('trip_link_booking')->insertGetId(
            [
                'trip_id'=> $inquiry->booking_id, 
                'booking_id' => $inquiry->booking_id,
            ]
        );
        
        return $this->success(null,'Succesfully sent your inquiry.');
    }
}
