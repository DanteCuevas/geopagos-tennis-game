<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TournamentService;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\MatchPlayer;

class TournamentGameTest extends TestCase
{

    public function test_tournament_create_for_male_or_female()
    {
        $gender = collect(['male', 'female'])->random();
        $exp = rand(1, 6);
        $total = pow(2, $exp);
        $matchRounds = $total / 2;
        $players = Player::factory($total)->male()->create();

        $tournamentService = new TournamentService();
        $tournamentService->setGender($gender)->setPlayers($players)->play();
        $tournament = $tournamentService->getResult();

        $this->assertModelExists($tournament);
        $this->assertEquals($gender, $tournament->gender);
        $this->assertNotNull($tournament->winner_id);

        $schedules = Schedule::where('tournament_id', $tournament->id)->orderBy('number')->get();
        $this->assertEquals($exp, $schedules->count());
        
        foreach ($schedules as $key => $schedule) {
            $matchPlayers = MatchPlayer::where('schedule_id', $schedule->id)->get();
            $this->assertEquals($matchRounds, $matchPlayers->count());
            $matchRounds = $matchRounds / 2;
        }

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $tournament->delete();
        foreach ($players as $key => $player) {
            $player->delete();
        }
    }

}
