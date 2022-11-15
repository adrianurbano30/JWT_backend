<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LikeResource;

class ComentarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
        'id'=> $this->id,
        'comentarios'=>$this->comentarios,
        'User'=>new UserResource($this->user),
        'editado'=>$this->editado,
        'Likes'=>LikeResource::collection($this->likes),
        'comentarioable_id'=>$this->comentarioable_id,
        'comentarioable_type'=>$this->comentarioable_type,
        'parent_id'=>$this->parent_id,
        'Respuestas'=>ComentarioResource::collection($this->replies),
        'created_at'=>$this->created_at,
        'updated_at'=>$this->updated_at
        ];
    }
}
