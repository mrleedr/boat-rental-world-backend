<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' =>  $this->currency_display,
            'currency_display' =>  $this->currency_display,
            'status' =>  $this->currency_display,
            'description' =>  $this->description,
            'marketing_consent' => $this->marketing_consent ? true : false,
            'language_spoken' => $this->language_spoken(),
            'timezone' => $this->time_zone,
        ];
    }
}
