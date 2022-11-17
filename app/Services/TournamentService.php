<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\MatchPlayer;

class TournamentService {

    private $tournament;
    private $gender;
    private $players;
    private $roundNumber;
    private $currentSchedule;
    private $gameResult;

    public function __construct()
    {
        $this->roundNumber  = 1;
    }

    public function setPlayers($players): TournamentService
    {
        $this->players = $players;
        return $this;
    }

    public function setGender($gender): TournamentService
    {
        $this->gender = $gender;
        return $this;
    }

    public function play(): TournamentService
    {
        $this->startTournament();
        $this->startRounds();
        $this->endTournament();
        return $this;
    }

    public function getResult()
    {
        return $this->tournament;
    }

    private function startTournament()
    {
        $this->tournament = Tournament::create([
            'date_start'    => now()->format('Y-m-d'),
            'gender'        => $this->gender
        ]);
    }

    private function startRounds()
    {
        while ($this->players->count() !== 1) {
            $this->saveSchedule();
            $this->saveMatchPlayers();
            $this->roundNumber++;
        }
    }

    private function saveSchedule()
    {
        $this->currentSchedule = $this->tournament->schedules()->create([
            'number'        => $this->roundNumber,
            'date_start'    => now()->format('Y-m-d')
        ]);
    }

    private function saveMatchPlayers()
    {
        $matches = []; $playerWinners = [];
        for ($i=0; $i < $this->players->count(); $i+=2) {
            $gameService = new GameService($this->players[$i], $this->players[$i+1]);
            $gameService->play();
            $this->gameResult = $gameService->getResult();
            array_push($playerWinners, $this->gameResult->player_winner);
            array_push($matches, $this->dataMatchPlayer());
        }
        MatchPlayer::insert($matches);
        $this->players = collect($playerWinners);
    }

    private function dataMatchPlayer()
    {
        return [
            'schedule_id'   => $this->currentSchedule->id,
            'player_one_id' => $this->gameResult->player_one->id,
            'player_two_id' => $this->gameResult->player_two->id,
            'date_start'    => now()->format('Y-m-d'),
            'winner'        => $this->gameResult->winner,
            'created_at'    => now(),
            'updated_at'    => now()
        ];
    }

    private function endTournament()
    {
        $this->tournament->winner_id = $this->players[0]->id;
        $this->tournament->date_end = now()->format('Y-m-d');
        $this->tournament->save();
    }

}