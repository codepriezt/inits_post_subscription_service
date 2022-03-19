<?php

namespace App\Http\Resources;

use App\Http\Resources\SubscriberResource;
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
            'id' => $this->id,
            'firstName' =>  ucwords($this->first_name),
            'lastName' => ucwords($this->last_name),
            'email' => $this->email,
            'subscription' => $this->subscription
        ];
    }
}
