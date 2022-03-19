<?php

namespace App\Http\Resources;


use App\Http\Resources\UserResource;
use App\Http\Resources\WebsiteResource;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
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
            'user' => $this->user->full_name,
            'user_id'=>$this->user->id,
            'website' => $this->website->name,
            'website_id'=> $this->website->id
        ];
    }
}
