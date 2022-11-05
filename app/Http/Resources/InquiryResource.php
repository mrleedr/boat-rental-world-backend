<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
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
            'id' => $this->booking_id,
            'duration_hour' => $this->duration_hour,
            'duration_minutes' => $this->duration_minutes,
            'overnight' => $this->overnight,
            'preferred_date' => $this->preferred_date,
            'return_date' => $this->return_date,
            'pick_up_time' => $this->pick_up_time,
            'drop_off_time' => $this->drop_off_time,
            'no_of_guest' => $this->no_of_guest,
            'other_request' => $this->other_request,
            'operator_status' => $this->operator_status(),
            'alternative_dates' => $this->alternative_dates(),
            'booking_addons' => $this->booking_addons(),
            'client' => $this->client(),
            'booking_status' => $this->booking_status(),
        ];
    }
}
