<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    use HttpResponses;
    
    public function getCurrency(Request $request)
    {   
        $search = $request->input('search');
        $orderBy =  $request->input('orderBy');
        $limit = $request->input('limit');

        $response =  DB::table('currency')
                    ->select('currency_id as value', 'description as label')
                    ->when($search, function ($query, $search) {
                        $query->where('description','like', "%$search%");
                    })
                    ->when($orderBy, function ($query, $orderBy) {
                        $query->orderBy('description', $orderBy);
                    })
                    ->when($limit, function ($query, $limit) {
                        $query->limit($limit);
                    })
                    ->get();

       return $this->success(['items' => $response]);
    }

    public function getTimezone(Request $request)
    {   
       $search = $request->input('search');
       $orderBy =  $request->input('orderBy');
       $limit = $request->input('limit');
       
       $response =  DB::table('timezone')
                    ->select('timezone_id as value', 'description as label')
                    ->when($search, function ($query, $search) {
                        $query->where('description','like', "%$search%");
                    })
                    ->when($orderBy, function ($query, $orderBy) {
                        $query->orderBy('description', $orderBy);
                    })
                    ->when($limit, function ($query, $limit) {
                        $query->limit($limit);
                    })
                    ->get();

       return $this->success(['items' => $response]);
    }

    public function getLanguageSpoken(Request $request)
    {   
       $search = $request->input('search');
       $orderBy =  $request->input('orderBy');
       $limit = $request->input('limit');
       
       $response =  DB::table('language_spoken')
                    ->select('language_spoken_id as value', 'description as label')
                    ->when($search, function ($query, $search) {
                        $query->where('description','like', "%$search%");
                    })
                    ->when($orderBy, function ($query, $orderBy) {
                        $query->orderBy('description', $orderBy);
                    })
                    ->when($limit, function ($query, $limit) {
                        $query->limit($limit);
                    })
                    ->get();

       return $this->success(['items' => $response]);
    }

    public function getTripAddon(Request $request)
    {   
        $validated = $request->validate([
            'tour' => 'required|numeric',
        ]);

       $search = $request->input('search');
       $orderBy =  $request->input('orderBy');
       $limit = $request->input('limit');
       $tour = $request->input('tour');
       
       $response =  DB::table('trip_link_trip_addon')
                    ->join('trip_addon','trip_link_trip_addon.trip_addon_id','trip_addon.trip_addon_id')
                    ->select('trip_addon.trip_addon_id as value', 'trip_addon.description as label')
                    ->where('trip_link_trip_addon.trip_id',$tour)
                    ->when($search, function ($query, $search) {
                        $query->where('description','like', "%$search%");
                    })
                    ->when($orderBy, function ($query, $orderBy) {
                        $query->orderBy('description', $orderBy);
                    })
                    ->when($limit, function ($query, $limit) {
                        $query->limit($limit);
                    })
                    ->get();

       return $this->success(['items' => $response]);
    }
    
}
