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
}
