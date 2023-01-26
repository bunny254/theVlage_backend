<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'guests' => $this->number_of_guests,
            'price' => $this->price,
            'rent_cost' => $this->rent_cost,
            'deposit_cost' => $this->deposit_cost,
            'amenities_cost' => $this->amenities_cost,
            'other_costs' => $this->other_costs,
            'date_booked' => $this->created_at,
            'check_in' => $this->check_in_date,
            'check_out' => $this->check_out_date,
            'admin_confirmed' => $this->admin_confirmed,
            'landlord_confirmed' => $this->landlord_confirmed,
            'status' => $this->status,
            'is_trashed' => boolval($this->trashed()),
            'stay_duration' => $this->check_in_date->diffInDays($this->check_out_date),
            'property' => new PropertyListResource($this->property),
            'customer' => new UserResource($this->author),
        ];
    }
}
