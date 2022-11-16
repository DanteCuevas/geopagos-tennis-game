<?php

namespace App\Http\Resources\Tournament;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      title="TournamentServiceResource",
 *      description="Resource collection  game of tournament",
 *      @OA\Xml(
 *          name="TournamentServiceResource"
 *      ),
 *      @OA\Property(
 *          property="success",
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="data",
 *          type="object",
 *              @OA\Property(
 *                  property="id",
 *                  ref="#/components/schemas/Tournament/properties/id"
 *              ),
 *              @OA\Property(
 *                  property="gender",
 *                  ref="#/components/schemas/Tournament/properties/gender"
 *              ),
 *              @OA\Property(
 *                  property="date_start",
 *                  ref="#/components/schemas/Tournament/properties/date_start"
 *              ),
 *              @OA\Property(
 *                  property="date_end",
 *                  ref="#/components/schemas/Tournament/properties/date_end"
 *              ),
 *              @OA\Property(
 *                  property="winner_id",
 *                  ref="#/components/schemas/Tournament/properties/winner_id"
 *              ),
 *              @OA\Property(
 *                  property="winner",
 *                  type="object",
 *                      @OA\Property(
 *                          property="id",
 *                          type="integer"
 *                      ),
 *                      @OA\Property(
 *                          property="first_name"
 *                      ),
 *                      @OA\Property(
 *                          property="last_name"
 *                      ),
 *                      @OA\Property(
 *                          property="gender"
 *                      )
 *              )
 *          )
 *      )
 * )
 */
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
