<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone_number' => $this->customer_phone_number,
            'txn_id' => $this->txn_id,
            'txn_ref' => $this->txn_id,
            'flw_ref' => $this->flw_ref,
            'currency' => $this->currency,
            'amount_charged' => $this->amount_charged,
            'app_fee' => $this->app_fee,
            'merchant_fee' => $this->merchant_fee,
            'amount_settled' => $this->amount_settled,
            'is_verified' => boolval($this->is_verified),
            'status' => $this->status,
            'booking' => new BookingResource($this->booking)
        ];
    }
}
