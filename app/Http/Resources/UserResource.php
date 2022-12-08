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
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' =>  $this->last_name,
            'currency_display' =>  $this->currency_display,
            'status' =>  $this->status,
            'description' =>  $this->description,
            'marketing_consent' => $this->marketing_consent ? true : false,
            'language_spoken' => $this->language_spoken(),
            'timezone' => $this->time_zone,
        ];
    }
}
