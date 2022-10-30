<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $primaryKey = "user_id";

    protected $fillable = ['*'];


    
    /**
     * Get The available language spoken by user
     *
     * @var array<int, string>
     */
    public function language_spoken(){
        return $this->join('user_link_language_spoken', 'users.user_id', 'user_link_language_spoken.user_id')
                    ->join('language_spoken', 'user_link_language_spoken.language_spoken_id', 'language_spoken.language_spoken_id')
                    ->select('language_spoken.*')
                    ->where('users.user_id', $this->user_id)
                    ->get()->toArray();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
