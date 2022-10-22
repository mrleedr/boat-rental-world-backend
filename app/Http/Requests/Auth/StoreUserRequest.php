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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'language_spoken' => ['required', 'string', 'max:10'],
            'currency_display' => ['required', 'string', 'max:10'],
            'marketing_consent' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'max:50'],
        ];
    }

    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'first_name' => 'trim|lowercase',
            'last_name' => 'trim|lowercase',
            'language_spoken' => 'trim|lowercase',
            'currency_display' => 'trim|uppercase',
        ];
    }
}
