<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tour\PublicToursRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PublicToursRequest $request)
    {
       //
    }

    public function getPublishTours(PublicToursRequest $request)
    {
        
        $isLocationAvailable = !!$request->latitude && !!$request->longitude ? true : false;

        $tours = Trip::where('trip_status_id',1)
                      ->join('trip_link_location','trip.trip_id','trip_link_location.trip_id')
                      ->join('location','trip_link_location.location_id','location.location_id')
                      ->when($request->search && !$isLocationAvailable, function ($query, $search) {
                         return $query->where('address','like',"%$search%")
                              ->orWhere('city','like',"%$search%")
                              ->orWhere('state','like',"%$search%")
                              ->orWhere('country','like', "%$search%");
                       })
                      ->select('trip.*','location.*')
                      ->get()
                      ->collect();
                      
        if($isLocationAvailable){
            foreach($tours as $tour){                
                /* Check if the it is within area */
                $tour->isWithinArea = $this->isNear($request->latitude,$request->longitude,$tour->latitude,$tour->longitude);
            }
        }
        
       return TripResource::collection(
            $tours->when($isLocationAvailable, function ($query) {
                return $query->where('isWithinArea',true);
            })
       );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTrip($trip_id)
    {
        $trip = Trip::where('trip_id', $trip_id)->first();

        if($trip && $trip->trip_status_id !== 2){
            return $this->error('Tour is not published yet', 'Invalid Tour Request', 400);
        }elseif(!$trip){
            return $this->error('Tour is not existing.', 'Invalid Tour Request', 400);
        }

        return new TripResource($trip);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show($trip)
    {   
        $tour = Trip::where('trip_id', $trip)->first();
        return new TripResource($tour);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        //
    }

    public function isNear($lat1, $lon1, $lat2, $lon2, $unit = null) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        // if ($unit == "K") {
        //     return ($miles * 1.609344);
        // } else if ($unit == "N") {
        //     return ($miles * 0.8684);
        // } else {
        //     return $miles;
        // }

        /* is within 50 mile radius */
        return $miles <= 1 ? true : false;
      }
}
