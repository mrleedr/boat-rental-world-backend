<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['numeric'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'max:50', 'unique:users'],
            'phone' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'language_spoken' => ['required','array'],
            // 'language_spoken.*' => ['numeric'],
            'currency_display' => ['required', 'string', 'max:10'],
            'marketing_consent' => ['required', 'boolean'],
            'timezone' => ['required', 'string', 'max:50'],
        ];
    }
}
