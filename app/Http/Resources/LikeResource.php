<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'User'=>new UserResource($this->user),
            'likeable_id'=>$this->likeable_id,
            'likeable_type'=>$this->likeable_type,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->created_at
        ];
    }
}
