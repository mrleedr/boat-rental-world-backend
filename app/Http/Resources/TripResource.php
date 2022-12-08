<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'id' => $this->trip_id,
            'head_line' => $this->head_line,
            'description' => $this->description,
            'pictures' => $this->pictures(),
            'vessel' =>  array_merge($this->vessel(), ['vessel_features' => $this->vessel_features()]),
            'categories' => $this->categories(),
            'location' => $this->location(),
            'pricing' => $this->pricing(),
            'addons' => $this->addons(),
            'ratings' => $this->review_ratings(),
            'user' => $this->user(),
            'trip_status' => $this->trip_status(),
            'operator_status' => $this->operator_status(),
        ];
    }
}
