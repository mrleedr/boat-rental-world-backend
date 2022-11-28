<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
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
            'user_id' => ['required','numeric'],
            'first_name' => ['string', 'max:50'],
            'last_name' => ['string', 'max:50'],
            'password' => ['confirmed', Rules\Password::defaults()],
            'language_spoken' => ['array'],
            'language_spoken.*' => ['numeric'],
            'currency_display' => ['string', 'max:10'],
            'marketing_consent' => ['boolean'],
            'timezone' => ['string', 'max:50'],
        ];
    }
}
