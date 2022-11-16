<?php

namespace App\Http\Resources\Tournament;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *      title="TournamentServiceCollection",
 *      description="Resource collection of tournaments",
 *      @OA\Xml(
 *          name="TournamentServiceCollection"
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
 *          type="array",
 *          @OA\Items(
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
class TournamentIndexCollection extends ResourceCollection
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
            'message'   => 'Tournaments retrieved successfully',
            'data'      => $this->collection->transform(function ($item) {
                return [
                    'id'            => $item->id,
                    'date_start'    => $item->date_start,
                    'date_end'      => $item->date_end,
                    'gender'        => $item->gender,
                    'winner_id'     => $item->winner_id,
                    'winner'        => [
                        'id'            => $item->winner->id,
                        'first_name'    => $item->winner->first_name,
                        'last_name'     => $item->winner->last_name,
                        'gender'        => $item->winner->gender
                    ]
                ];
            })
            
        ];
    }
}
