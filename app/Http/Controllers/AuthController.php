<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->authenticate();

        $user = User::where('email', $request->email)->first();

        $response = new UserResource($user);

        return $this->success([
            'user' => $response,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
        ], 'Successfully Login');
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = new User;
        $user->first_name =  $request->first_name;
        $user->last_name =  $request->last_name;
        $user->email =  $request->email;
        $user->password =  Hash::make($request->password);
        $user->currency_display = $request->currency_display;
        $user->marketing_consent = $request->marketing_consent ?? false;
        $user->timezone =  $request->timezone;
        $user->save();

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
            'token' => $user->createToken('API Token of ' . $user->first_name)->plainTextToken
        ], 'You are now registered');
    }

    public function authenticate()
    {
        $user = Auth::user();
        
        $response = new UserResource($user);

        return $this->success([
            'user' => $response,
        ], 'Successfully Login');

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null,'Succesfully Log out.');
    }

    public function passwordReset(PasswordResetRequest $request) 
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            $user = User::where('email', $request->email)->first();
            $response = new UserResource($user);
            return $this->success([
                'user' => $response,
                'token' => $user->createToken('API Token of ' . $user->first_name)->plainTextToken
            ], 'Your password has been successfully reset.');
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
    
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return $this->success(null,'Please check your email.');
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function redirectToAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function handleAuthCallback()
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $user = User::where('email',$socialiteUser->user['email'])->first();

        if(!$user){
            $user = new User;
            $user->first_name =  $socialiteUser->user['given_name'];
            $user->last_name =  $socialiteUser->user['family_name'];
            $user->email =  $socialiteUser->user['email'];
            $user->google_id =  $socialiteUser->user['id'];
            $user->save();
        }

        $response = new UserResource($user);

        return $this->success([
            'user' => $response,
            'token' => $user->createToken('API Token of' . $user->first_name)->plainTextToken,
        ]);
}
}
