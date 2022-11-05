<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\InquiryRequest;
use App\Http\Resources\InquiryResource;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\NewInquiryNotification;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookingController extends Controller
{
    use HttpResponses;

         /**
     * Create an inquiry
     *
     * @return \Illuminate\Http\Response
     */
    public function createInquiry(InquiryRequest $request)
    {
        $user = Auth::user();
        $alternative_dates = (object) $request->alternative_dates;
        $booking_addons = (object) $request->booking_addons;

        $inquiry = new Booking;
        $inquiry->operator_status_id = $request->operator_status;
        $inquiry->duration_hour = $request->duration_hour;
        $inquiry->duration_minutes = $request->duration_minutes;
        $inquiry->overnight = $request->overnight;
        $inquiry->preferred_date = $request->preferred_date;
        $inquiry->return_date = $request->return_date;
        $inquiry->pick_up_time = $request->pick_up_time;
        $inquiry->drop_off_time = $request->drop_off_time;
        $inquiry->no_of_guest = $request->no_of_guest;
        $inquiry->other_request = $request->other_request;
        $inquiry->booking_status_id = 1; // New Inquiry
        $inquiry->save();


        /* Creating a link to user */
        DB::table('user_link_booking')->insert(
            ['user_id' => $user->user_id, 'booking_id' => $inquiry->booking_id],
        );

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

        /* Link booking to trip */
        DB::table('trip_link_booking')->insertGetId(
            [
                'trip_id'=> $request->trip_id, 
                'booking_id' => $inquiry->booking_id,
            ]
        );
        
        /* Send a notification to boat owner */
        $trip = (object) Trip::where('trip_id',  $request->trip_id)->first()->user();
        $owner = User::where ('user_id',$trip->user_id)->first();
        $owner->notify(new NewInquiryNotification($inquiry));

        return $this->success(null,'Succesfully sent your inquiry.');
    }


    public function getInquiry($inquiry_id)
    {
        $user = Auth::user();

        /* Check if inquiry exist */
        $inquiry = Booking::where('booking_id', $inquiry_id)->first();
        if(!$inquiry){
            return $this->error('Inquiry is not existing', 'Invalid Request', 400);
        }

        /* check if you are the allowed to view the inquiry*/
        $owner = $inquiry->trip_owner();
        $client = $inquiry->client();
        
        if($user->user_id !== $owner['user_id'] &&  $user->user_id !== $client['user_id']){
            return $this->error('You are not authorized to view the request', 'Invalid Request', 403);
        }

        $response =  new InquiryResource($inquiry);
        return $this->success($response);
    }

    public function getInquiries(Request $request)
    {
        $user = Auth::user();

        $orderBy =  $request->input('orderBy') ?? 'preferred_date';
        $sortOrder =  $request->input('sortOrder') ?? "DESC";
        $tour = $request->input('tour'); 
        $booking = $request->input('booking');
        $client = $request->input('clinet');
        
        $inquiries = Booking::when($tour, function($query, $tour){
            return $query->join('trip_link_booking','trip_link_booking.booking_id','booking.booking_id')
                    ->where('trip_link_booking.trip_id', $tour);
        })->get();

        $response = InquiryResource::collection($inquiries)->paginate(20);
        return $this->success($response);
    }


}
