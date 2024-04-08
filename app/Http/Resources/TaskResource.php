<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TaskResource extends JsonResource
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
            
            'id'=>(string)$this->id,
            'loc_det'=>[
                'city'=>$this->city,
                'location'=>$this->location,
                'address'=>$this->address,
                
                ],
            'str_det'=>[
            'type'=>$this->type,
            'size'=>$this->size,
            'bedrooms'=>$this->bedrooms,
            'bathrooms'=>$this->bathrooms,
                ],
            'description'=>$this->description,
            'owner_data'=>[
                    'owner id'=>(string)Auth::user()->id,
                    'owner name' => Auth::user()->name,
                    'owner email' => Auth::user()->email,
                    'owner phone' => Auth::user()->phone,                
            ],
        ];
    }
}
