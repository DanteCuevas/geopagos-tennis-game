<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tournament\TournamentIndexRequest;
use App\Http\Resources\Tournament\TournamentIndexCollection;
use App\Models\Tournament;
use App\Models\Schedule;
use App\Models\Player;
use App\Models\MatchPlayer;
use App\Services\TournamentService;

class TournamentController extends Controller
{

    /**
     * @OA\Get(
     *      path="/tournaments",
     *      operationId="getProjectsList",
     *      tags={"TOURNAMENTS"},
     *      summary="Get list of tournaments",
     *      description="Returns list of projects",
     *      @OA\Parameter(
     *          name="date_start",
     *          description="The date when start the tournament",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="gender",
     *          description="The gender of the tournament",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="winner_id",
     *          description="The id of a player",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="winner_name",
     *          description="The name of a player",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TournamentIndexCollection")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(TournamentIndexRequest $request)
    {
        $tournament = Tournament::with('winner')
            ->dateStart($request->date_start)
            ->dateEnd($request->date_end)
            ->gender($request->gender)
            ->winnerId($request->winner_id)
            ->filterWinner($request->winner_name)
            ->paginate(20);
        return new TournamentIndexCollection($tournament);
    }

    public function show($id)
    {
        $tournament = Tournament::with([
                'schedules',
                'schedules.match_players',
                'schedules.match_players.player_one',
                'schedules.match_players.player_two'
            ])
            ->find($id);

        if(empty($tournament))
            return response()->json(['message'=>'Tournament does not exist'], 404);
        return $tournament;
    }

    public function game(TournamentService $tournamentService)
    {
        $gender = collect(['male', 'female'])->random();
        $players = Player::gender($gender)->get()->shuffle();

        $tournamentService->setGender($gender)->setPlayers($players)->play();
        return $tournamentService->resultResource();
    }

}
