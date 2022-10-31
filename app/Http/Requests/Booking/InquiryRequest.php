<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
            'tour_id' => ['required', 'numeric'],
            'operator_status' => ['required', 'numeric'],
            'duration_hour' => ['numeric'],
            'duration_minutes' => ['numeric'],
            'overnight' => ['numeric'],
            'preferred_date' => ['required','date','after_or_equal:tomorrow'],
            'return_date' => ['required','date','after_or_equal:preferred_date'],
            'alternative_dates.*' => ['array',
                function($attribute, $value, $fail){
                    if( 
                        !is_array($value) || 
                        !array_key_exists('preferred_date', $value) || 
                        !array_key_exists('return_date', $value)
                    ){
                        $fail("The $attribute is not a valid date");
                    }
                }            
            ],
            'alternative_dates.*.preferred' => ['date','after_or_equal:tomorrow'],
            'alternative_dates.*.return_date' => ['date','after_or_equal:alternative_dates.*.preferred'],
            'pick_up_time' => ['required','date_format:H:i'],
            'drop_off_time' => ['required','date_format:H:i'],
            'no_of_guest' => ['required', 'numeric'],
            'booking_addons' => ['array'],
            'booking_addons.*' => ['array',
                function($attribute, $value, $fail){
                    if( 
                        !is_array($value) || 
                        !array_key_exists('trip_addon_id', $value) || 
                        !array_key_exists('quantity', $value) || 
                        !array_key_exists('other_request', $value)
                    ){
                        $fail("The $attribute is not a addon");
                    }
                }            
            ],
            'booking_addons.*.trip_addon_id' => ['numeric'],
            'booking_addons.*.quantity' => ['numeric'],
            'booking_addons.*.other_request' => ['string'],
            'other_request' => ['string'],
        ];
    }
}
