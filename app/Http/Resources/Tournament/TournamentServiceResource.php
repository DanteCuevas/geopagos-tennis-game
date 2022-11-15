<?php

namespace App\Http\Resources\Tournament;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentServiceResource extends JsonResource
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
            'success'   => true,
            'message'   => 'Tournament game retrieved successfully',
            'data'      => [
                'id'            => $this->id,
                'gender'        => $this->gender,
                'date_start'    => $this->date_start,
                'date_end'      => $this->date_end,
                'winner_id'     => $this->winner_id,
                'winner'        => [
                        'id'            => $this->winner->id,
                        'first_name'    => $this->winner->first_name,
                        'last_name'     => $this->winner->last_name,
                        'gender'        => $this->winner->gender
                ]
            ]
        ];
    }
}
