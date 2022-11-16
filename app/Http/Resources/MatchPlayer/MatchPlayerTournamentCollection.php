<?php

namespace App\Http\Resources\MatchPlayer;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *      title="MatchPlayerTournamentCollection",
 *      description="Resource collection of match players for tournaments",
 *      @OA\Xml(
 *          name="MatchPlayerTournamentCollection"
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="schedule_id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="player_one_id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="player_two_id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          type="date",
 *      ),
 *      @OA\Property(
 *          property="winner",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="player_one",
 *          type="object",
 *              @OA\Property(
 *                  property="id",
 *                  type="integer"
 *              ),
 *              @OA\Property(
 *                  property="first_name",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="last_name",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="gender",
 *                  type="string"
 *              )
 *      ),
 *      @OA\Property(
 *          property="player_two",
 *          type="object",
 *              @OA\Property(
 *                  property="id",
 *                  type="integer"
 *              ),
 *              @OA\Property(
 *                  property="first_name",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="last_name",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="gender",
 *                  type="string"
 *              )
 *      )
 * )
 */
class MatchPlayerTournamentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            return [
                'id'            => $item->id,
                'schedule_id'   => $item->schedule_id,
                'player_one_id' => $item->player_one_id,
                'player_two_id' => $item->player_two_id,
                'date_start'    => $item->date_start,
                'winner'        => $item->winner,
                'player_one'        => [
                    'id'            => $item->player_one->id,
                    'first_name'    => $item->player_one->first_name,
                    'last_name'     => $item->player_one->last_name,
                    'gender'        => $item->player_one->gender
                ],
                'player_two'        => [
                    'id'            => $item->player_two->id,
                    'first_name'    => $item->player_two->first_name,
                    'last_name'     => $item->player_two->last_name,
                    'gender'        => $item->player_two->gender
                ],
            ];
        });
    }
}
