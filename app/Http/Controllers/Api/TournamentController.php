<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Schedule;
use App\Models\Player;
use App\Models\MatchPlayer;
use App\Services\TournamentService;

class TournamentController extends Controller
{

    public function index()
    {
        $tournament = Tournament::paginate(20);
        return $tournament;
    }

    public function show($id)
    {
        $tournament = Tournament::with([
                'schedules',
                'schedules.match_users',
                'schedules.match_users.player_one',
                'schedules.match_users.player_two'
            ])
            ->find($id);

        if(empty($tournament))
            return response()->json(['message'=>'Tournament does not exist'], 404);
        return $tournament;
    }

    public function game(TournamentService $tournamentService)
    {
        $tournamentService->play();
        return $tournamentService->resultResource();
    }

}
