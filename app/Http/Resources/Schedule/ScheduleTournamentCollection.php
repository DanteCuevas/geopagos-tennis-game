<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\MatchPlayer\MatchPlayerTournamentCollection;

/**
 * @OA\Schema(
 *      title="ScheduleTournamentCollection",
 *      description="Resource collection of schedule for tournaments",
 *      @OA\Xml(
 *          name="ScheduleTournamentCollection"
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="tournament_id",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          type="date",
 *      ),
 *      @OA\Property(
 *          property="number",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="match_players",
 *          type="array",
 *          @OA\Items(
 *              ref="#/components/schemas/MatchPlayerTournamentCollection"
 *          )
 *      )
 * )
 */
class ScheduleTournamentCollection extends ResourceCollection
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
                'tournament_id' => $item->tournament_id,
                'date_start'    => $item->date_start,
                'number'        => $item->number,
                'match_players' => new MatchPlayerTournamentCollection($item->match_players)
            ];
        });
    }
}
