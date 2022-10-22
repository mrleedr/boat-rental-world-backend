<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tour\CreateTourRequest;
use App\Http\Requests\Tour\PublicToursRequest;
use App\Http\Requests\Tour\PublishTourRequest;
use App\Http\Resources\TripResource;
use App\Models\Location;
use App\Models\Pricing;
use App\Models\Trip;
use App\Models\Vessel;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Show the list of published Tours
     *
     * @return \Illuminate\Http\Response
     */
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
        
        
        $response = TripResource::collection(
            $tours->when($isLocationAvailable, function ($query) {
                return $query->where('isWithinArea',true);
            })
       );

        return $this->success($response);

    }

     /**
     * Show the details of a tour
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

        $response =  new TripResource($trip);

        return $this->success($response);
    }


    /**
     * Create / Update a Tour
     *
     * @return \Illuminate\Http\Response
    */
    public function create(CreateTourRequest $request)
    {
        $user = Auth::user();
        $pictures = $request->pictures;
        $categories =  (object) $request->categories;
        $request_vessel = (object) $request->vessel;
        $request_features = $request_vessel->features;
        $request_location = (object) $request->location;
        $request_price = (object) $request->price;

        /* check if for publish, if it is for publish validate it*/
        if($request->publish === true){
            $publishTourRequest = new PublishTourRequest;
            $publishTourRules = $publishTourRequest->rules();
            $request->validate($publishTourRules);
        }

        /* new */
        if(!$request->trip_id){
            $trip = new Trip;
            $trip->head_line =  $request->head_line;
            $trip->description =  $request->description;
            $trip->operator_status_id = 1;
            $trip->trip_status_id = $request->publish;
            $trip->save();

            /* Creating a link to user */
            DB::table('user_link_trip')->insert(
                ['user_id' => $user->user_id, 'trip_id' => $trip->trip_id],
            );
            
            /* Creating a link to pictures */
            if(!empty($pictures)){
                foreach($pictures as $pictureID){
                    DB::table('trip_link_trip_picture')->insert(
                        ['trip_id' => $trip->trip_id, 'trip_picture_id'=> $pictureID],                
                    );    
                }
            }

            if(!empty($categories)){
                foreach($categories as $item){
                    $category = (object) $item;
                    /* Create A category */
                    DB::table('trip_link_trip_category')->insert(
                        ['trip_category_id' => $category->trip_category_id, 
                        'trip_id'=> $trip->trip_id, 
                        'primary' => $category->primary]
                    );
                }
            }

            /* Creating a Vessel */
            $vessel = new Vessel;
            $vessel->make_model = $request_vessel->make_model;
            $vessel->length = $request_vessel->length;
            $vessel->year =  $request_vessel->year;
            $vessel->capacity = $request_vessel->capacity;
            $vessel->number_of_engines = $request_vessel->number_of_engines;
            $vessel->engine_horsepower = $request_vessel->engine_horsepower;
            $vessel->engine_brand = $request_vessel->engine_brand;
            $vessel->engine_model = $request_vessel->engine_model;
            $vessel->save();

            /* Creating a link to vessel */
            DB::table('trip_link_vessel')->insert(
                ['trip_id' => $trip->trip_id, 'vessel_id'=> $vessel->vessel_id],
            );

            /* Create a link from vessel to feature */
            foreach($request_features as $feature_id){
                DB::table('vessel_link_feature')->insert(
                    ['vessel_id' => $vessel->vessel_id, 'feature_id'=> $feature_id]
                );
            }

            /*Create a Location*/
            $location = new Location;
            $location->city = $request_location->city;
            $location->state= $request_location->state;
            $location->country = $request_location->country;
            $location->zip = $request_location->zip;
            $location->address = $request_location->address;
            $location->latitude = $request_location->latitude;
            $location->longitude = $request_location->longitude;
            $location->save();
            
            /* Create a link from to location */
            DB::table('trip_link_location')->insert(
                ['trip_id' => $trip->trip_id, 'location_id'=> $location->location_id],
            );

            /* Create a price*/
            $price = new Pricing;
            $price->currency =  $request_price->currency;
            $price->price_per_day =  $request_price->price_per_day;
            $price->per_day_minimum =  $request_price->per_day_minimum;
            $price->price_per_week =  $request_price->price_per_week;
            $price->price_per_hour =  $request_price->price_per_hour;
            $price->per_hour_minimum =  $request_price->per_hour_minimum;
            $price->price_per_night =  $request_price->price_per_night;
            $price->per_night_minimum =  $request_price->per_night_minimum;
            $price->security_allowance =  $request_price->security_allowance;
            $price->price_per_multiple_days =  $request_price->price_per_multiple_days;
            $price->per_multiple_days_minimum =  $request_price->per_multiple_days_minimum;
            $price->price_per_multiple_hours =  $request_price->price_per_multiple_hours;
            $price->per_multiple_hours_minimum =  $request_price->per_multiple_hours_minimum;
            $price->price_per_person =  $request_price->price_per_person;
            $price->per_person_minimum =  $request_price->per_person_minimum;
            $price->per_person_charge_type = $request_price->per_person_charge_type;
            $price->cancellation_refund_rate =  $request_price->cancellation_refund_rate;
            $price->cancellation_allowed_days =  $request_price->cancellation_allowed_days;
            $price->rental_terms =  $request_price->rental_terms;
            $price->save();
          
            /* Creating a link to pricing */
            DB::table('trip_link_pricing')->insert(
                ['trip_id' => $trip->trip_id, 'pricing_id'=> $price->pricing_id],
            );
        }else{
            /* For existing trours */
            $trip = Trip::where('trip_id',$request->trip_id)->first();

            /* Validate if the tour is existing */
            if(!$trip){
                return $this->error('', 'Tour is not existing', 404);
            }

            /* Validate if user is allowed to update the tour */
            if($trip){
                $trip_user = (object) $trip->user();
                if($trip_user->user_id !== $user->user_id ){
                    return $this->error('', 'User is not allowed to update the record.', 401);
                }
            }

            /* update general details */
            $trip->head_line =  $request->head_line;
            $trip->description =  $request->description;
            $trip->save();

            $trip->location = (object) $trip->location();
            $trip->vessel = (object) $trip->vessel();
            $trip->pricing = (object) $trip->pricing();
            $trip->user = (object) $trip->user();
            
            
           
            /* Replace and add picture links  */
            DB::table('trip_link_trip_picture')->where('trip_id', $trip->trip_id)->delete();
            /* Creating a link to pictures */
            if($pictures){
                foreach($pictures as $pictureID){
                    DB::table('trip_link_trip_picture')->insert(
                        ['trip_id' => $trip->trip_id, 'trip_picture_id'=> $pictureID],                
                    );    
                }
            }
          
            /* Replace and add categories  */
            DB::table('trip_link_trip_category')->where('trip_id', $trip->trip_id)->delete();

            /* Creating a link to category */
            if(!empty($categories)){
                foreach($categories as $item){
                    $category = (object) $item;
                    /* Create A category */
                    DB::table('trip_link_trip_category')->insert(
                        ['trip_category_id' => $category->trip_category_id, 
                        'trip_id'=> $trip->trip_id, 
                        'primary' => $category->primary]
                    );
                }
            }
            /* search a Vessel */
            $vessel = Vessel::where('vessel_id',$trip->vessel->vessel_id)->first();
            $vessel->make_model = $request_vessel->make_model;
            $vessel->length = $request_vessel->length;
            $vessel->year =  $request_vessel->year;
            $vessel->capacity = $request_vessel->capacity;
            $vessel->number_of_engines = $request_vessel->number_of_engines;
            $vessel->engine_horsepower = $request_vessel->engine_horsepower;
            $vessel->engine_brand = $request_vessel->engine_brand;
            $vessel->engine_model = $request_vessel->engine_model;
            $vessel->save();


          /* Replace and features to vessel */
            DB::table('vessel_link_feature')->where('vessel_id', $vessel->vessel_id)->delete();
            if(!empty($request_features)){
                foreach($request_features as $feature_id){
                    DB::table('vessel_link_feature')->insert(
                        ['vessel_id' => $vessel->vessel_id, 'feature_id'=> $feature_id]
                    );
                }
            }
           
            /* update a Location*/
            $location = Location::where('location_id', $trip->location->location_id)->first();
            $location->city = $request_location->city;
            $location->state= $request_location->state;
            $location->country = $request_location->country;
            $location->zip = $request_location->zip;
            $location->address = $request_location->address;
            $location->latitude = $request_location->latitude;
            $location->longitude = $request_location->longitude;
            $location->save();

            /* update a price*/
            $price = Pricing::where('pricing_id', $trip->pricing->pricing_id)->first();
            $price->currency =  $request_price->currency;
            $price->price_per_day =  $request_price->price_per_day;
            $price->per_day_minimum =  $request_price->per_day_minimum;
            $price->price_per_week =  $request_price->price_per_week;
            $price->price_per_hour =  $request_price->price_per_hour;
            $price->per_hour_minimum =  $request_price->per_hour_minimum;
            $price->price_per_night =  $request_price->price_per_night;
            $price->per_night_minimum =  $request_price->per_night_minimum;
            $price->security_allowance =  $request_price->security_allowance;
            $price->price_per_multiple_days =  $request_price->price_per_multiple_days;
            $price->per_multiple_days_minimum =  $request_price->per_multiple_days_minimum;
            $price->price_per_multiple_hours =  $request_price->price_per_multiple_hours;
            $price->per_multiple_hours_minimum =  $request_price->per_multiple_hours_minimum;
            $price->price_per_person =  $request_price->price_per_person;
            $price->per_person_minimum =  $request_price->per_person_minimum;
            $price->per_person_charge_type = $request_price->per_person_charge_type;
            $price->cancellation_refund_rate =  $request_price->cancellation_refund_rate;
            $price->cancellation_allowed_days =  $request_price->cancellation_allowed_days;
            $price->rental_terms =  $request_price->rental_terms;
            $price->save();

        }

        $response = new TripResource($trip);

        return $this->success($response,'Successfully created/updated the tour!',201);
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
