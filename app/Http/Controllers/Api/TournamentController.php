<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Schedule;
use App\Models\Player;
use App\Models\MatchPlayer;

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

    public function game()
    {
        $data = [
            'date_start'    => now()->format('Y-m-d'),
            'gender'        => collect(['male', 'female'])->random()
        ];
        $tournament = Tournament::create($data);
        $players = Player::gender($tournament->gender)->get()->shuffle();

        $round = $players->count();
        $number = 1;
        while ($round !== 1) {
            $schedule = $tournament->schedules()->create([
                'number'        => $number,
                'date_start'    => now()->format('Y-m-d')
            ]);
            $matches = []; $newPlayers = [];
            for ($i=0; $i < $round; $i+=2) {
                $data = [
                    'schedule_id'   => $schedule->id,
                    'player_one_id' => $players[$i]->id,
                    'player_two_id' => $players[$i+1]->id,
                    'date_start'    => now()->format('Y-m-d'),
                    'winner'        => collect(['one', 'two'])->random(),
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
                $player = $data['winner'] === 'one' ? $players[$i] : $players[$i+1];
                array_push($newPlayers, $player);
                array_push($matches, $data);
            }
            MatchPlayer::insert($matches);
            $players = $newPlayers;
            $round = $round/2;
            $number++;
        }

        $tournament->winner_id = $players[0]->id;
        $tournament->date_end = now()->format('Y-m-d');
        $tournament->save();

        return $tournament;
    }

}
