<?php

namespace App\Services;

//use App\Services\GameService;
use App\Models\Tournament;
use App\Models\Player;
use App\Models\MatchPlayer;
use App\Http\Resources\Tournament\TournamentServiceResource;

Class TournamentService {

    private $tournament;
    private $players;
    private $totalPlayers;
    private $roundNumber;
    private $currentSchedule;
    private $gameResult;

    public function __construct()
    {
        $this->tournament   = $this->start();
        $this->players      = $this->getInitialPlayers();
        $this->totalPlayers = $this->players->count();
        $this->roundNumber  = 1;
    }

    public function play(): TournamentService
    {
        $this->startRounds();
        $this->endTournament();
        return $this;
    }

    public function resultResource()
    {
        return new TournamentServiceResource($this->tournament);
    }

    private function start()
    {
        return Tournament::create([
            'date_start'    => now()->format('Y-m-d'),
            'gender'        => collect(['male', 'female'])->random()
        ]);
    }

    private function getInitialPlayers()
    {
        return Player::gender($this->tournament->gender)->get()->shuffle();
    }

    private function startRounds()
    {
        while ($this->totalPlayers !== 1) {
            $this->saveSchedule();
            $this->saveMatchPlayers();
            $this->totalPlayers = $this->totalPlayers/2;
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
        for ($i=0; $i < $this->totalPlayers; $i+=2) {
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