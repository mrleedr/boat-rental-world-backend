<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    use HttpResponses;
    
    public function updateUser(UpdateUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::where('user_id',$request->user_id)->first();

        if($user){
            $user->first_name =  $request->first_name;
            $user->last_name =  $request->last_name;
            $user->currency_display = $request->currency_display;
            $user->marketing_consent = $request->marketing_consent ?? false;
            $user->timezone =  $request->timezone;
            $user->save();
        }

        /* default to english */
        DB::table('user_link_language_spoken')->insert(
            [
                'user_id'=> $user->user_id, 
                'language_spoken_id' => 15,
            ]
        );
        
        $response = new UserResource($user);

        return $this->success([
            'user' => $response,
        ], 'Success');
    }
    
}
