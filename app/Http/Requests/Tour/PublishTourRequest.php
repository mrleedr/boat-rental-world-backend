<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class PublishTourRequest extends FormRequest
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
            'trip_id' =>  ['required','numeric'],
            'head_line' => ['required','string','max:50'],
            'description' => ['required','string','max:255'],
            'categories' => ['required','array','min:3',
                function($attribute, $value, $fail){
                    /* one must be a primary category */
                    if( 
                        is_array($value)
                    ){
                     
                        $primary = array_filter($value,function ($category){
                        
                            return $category['primary'] === true;
                        });
                    
                        if(count($primary) > 1){
                            $fail("Please select one primary category");
                        }
                    }
                }     
            ],
            'categories.*' => ['array',
                function($attribute, $value, $fail){
                        /* validate if the values is in correct object structure */
                        if( 
                            !is_array($value) || 
                            !array_key_exists('trip_category_id', $value) || 
                            !array_key_exists('primary', $value)
                        ){
                            $fail("The $attribute is not a valid trip category");
                        }
                    }            
                ],
            'categories.*.trip_category_id' => ['required','numeric'],
            'categories.*.primary' => ['required','boolean'],
            'pictures' => ['required','array','min:3'],
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
            'location.city' => ['required','string','max:50'],
            'location.state' => ['required','string','max:50'],
            'location.country' => ['required','string','max:50'],
            'location.zip' => ['required','string','max:50'],
            'location.address' => ['required','string','max:255'],
            'location.latitude' => ['required','numeric'],
            'location.longitude' => ['required','numeric'],
            'price.currency' => ['required', 'string', 'max:5'],
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
            'price.rental_terms' => ['required', 'numeric'],
        ];
    }
}
