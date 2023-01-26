<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyViewResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'unit_size' => $this->unit_size,
            'listing_type' => $this->listing_type,
            'building_type' => $this->building_type,
            'stay_type' => $this->stay_type,
            'is_furnished' => $this->is_furnished,
            'rent_cost' => $this->rent_cost,
            'utilities_cost' => $this->utilities_cost,
            'deposit_months' => $this->deposit_months,
            'deposit' => $this->deposit(),
            'currency' => $this->currency,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'location' => $this->location,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'cover_image' => $this->cover_image,
            'description' => $this->description,
            'amenities' => $this->amenities,
            'services' => $this->services,
            'available_from' => $this->available_from,
            'is_trashed' => boolval($this->trashed()),
            'owner' => $this->when(auth()->check() && auth()->user()->hasAnyRole('admin', 'master'), function () {
                return new UserResource($this->author);
            }),
            'images' => ImageResource::collection($this->images),
        ];
    }
}
