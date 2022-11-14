<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayerIndexCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success'   => true,
            'message'   => 'Players retrieved successfully',
            'data'      => $this->collection->transform(function ($item) {
                return [
                    'id'            => $item->id,
                    'first_name'    => $item->first_name,
                    'last_name'     => $item->last_name,
                    'gender'        => $item->gender,
                    'skill'         => $item->skill,
                    'strength'      => $item->strength,
                    'speed'         => $item->speed,
                    'reaction'      => $item->reaction
                ];
            })
            
        ];
    }
}
