<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CreateTourRequest extends FormRequest
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
            'trip_id' =>  ['nullable','numeric'],
            'head_line' => ['nullable','string','max:50'],
            'description' => ['nullable','string','max:255'],
            'categories' => ['array'],
            'categories.*' => ['array',
                function($attribute, $value, $fail){
                        if( 
                            !is_array($value) || 
                            !array_key_exists('trip_category_id', $value) || 
                            !array_key_exists('primary', $value)
                        ){
                            $fail("The $attribute is not a valid trip category");
                        }
                    }            
                ],
            'categories.*.trip_category_id' => ['numeric'],
            'categories.*.primary' => ['boolean'],
            'pictures' => ['array'],
            'pictures.*' => ['numeric'],
            'vessel.make_model' => ['nullable', 'string'],
            'vessel.length' => ['nullable', 'string'],
            'vessel.year' => ['nullable', 'string'],
            'vessel.capacity' => ['nullable', 'numeric'],
            'vessel.number_of_engines' => ['nullable', 'numeric'],
            'vessel.engine_horsepower' => ['nullable', 'numeric'],
            'vessel.engine_model' => ['nullable', 'string'],
            'vessel.features' => ['nullable', 'array'],
            'vessel.features.*' => ['numeric'],
            'location.city' => ['nullable','string','max:50'],
            'location.state' => ['nullable','string','max:50'],
            'location.country' => ['nullable','string','max:50'],
            'location.zip' => ['nullable','string','max:50'],
            'location.address' => ['nullable','string','max:255'],
            'location.latitude' => ['nullable','numeric'],
            'location.longitude' => ['nullable','numeric'],
            'price.currency' => ['nullable', 'string', 'max:5'],
            'price.price_per_day' => ['nullable', 'numeric'],
            'price.per_day_minimum' => ['nullable', 'numeric'],
            'price.price_per_week' => ['nullable', 'numeric'],
            'price.price_per_hour' => ['nullable', 'numeric'],
            'price.per_hour_minimum' => ['nullable', 'numeric'],
            'price.price_per_night' => ['nullable', 'numeric'],
            'price.per_night_minimum' => ['nullable', 'numeric'],
            'price.security_allowance' => ['nullable', 'numeric'],
            'price.price_per_multiple_days' => ['nullable', 'numeric'],
            'price.per_multiple_days_minimum' => ['nullable', 'numeric'],
            'price.price_per_multiple_hours' => ['nullable', 'numeric'],
            'price.per_multiple_hours_minimum' => ['nullable', 'numeric'],
            'price.price_per_person' => ['nullable', 'numeric'],
            'price.per_person_charge_type' => ['nullable', 'numeric'],
            'price.cancellation_refund_rate' => ['nullable', 'numeric'],
            'price.cancellation_allowed_days' => ['nullable', 'numeric'],
            'price.rental_terms' => ['nullable', 'numeric'],
        ];
    }
}