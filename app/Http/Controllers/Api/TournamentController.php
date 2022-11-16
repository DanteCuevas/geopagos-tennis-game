<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tournament\TournamentIndexRequest;
use App\Http\Resources\Tournament\TournamentIndexCollection;
use App\Http\Resources\Tournament\TournamentShowResource;
use App\Http\Resources\Tournament\TournamentServiceResource;
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
     *      operationId="tournaments-index",
     *      tags={"TOURNAMENTS"},
     *      summary="Get list of tournaments",
     *      description="Get list of tournaments",
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

    /**
     * @OA\Get(
     *      path="/tournaments/{id}",
     *      operationId="tournament-show",
     *      tags={"TOURNAMENTS"},
     *      summary="Show one tournament",
     *      description="Show one tournament",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of the tournament",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TournamentShowResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     *     )
     */
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
        return new TournamentShowResource($tournament);
    }

    /**
     * @OA\Post(
     *      path="/tournaments-game",
     *      operationId="tournament-game",
     *      tags={"TOURNAMENTS"},
     *      summary="Game of a tournament",
     *      description="Game of a tournament",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TournamentServiceResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     *     )
     */
    public function game(TournamentService $tournamentService)
    {
        $gender = collect(['male', 'female'])->random();
        $players = Player::gender($gender)->get()->shuffle();

        $tournamentService->setGender($gender)->setPlayers($players)->play();
        return new TournamentServiceResource($tournamentService->getResult());
    }

}
