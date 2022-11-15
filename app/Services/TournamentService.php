<?php

namespace App\Services;

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

    public function __construct()
    {
        $this->tournament   = $this->start();
        $this->players      = $this->getInitialPlayers();
        $this->totalPlayers = $this->players->count();
        $this->roundNumber  = 1;
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
        $matches = []; $winnerPlayers = [];
        for ($i=0; $i < $this->totalPlayers; $i+=2) {
            $data = [
                'schedule_id'   => $this->currentSchedule->id,
                'player_one_id' => $this->players[$i]->id,
                'player_two_id' => $this->players[$i+1]->id,
                'date_start'    => now()->format('Y-m-d'),
                'winner'        => collect(['one', 'two'])->random(),
                'created_at'    => now(),
                'updated_at'    => now()
            ];
            $player = $data['winner'] === 'one' ? $this->players[$i] : $this->players[$i+1];
            array_push($winnerPlayers, $player);
            array_push($matches, $data);
        }
        MatchPlayer::insert($matches);
        $this->players = collect($winnerPlayers);
    }

    private function endTournament()
    {
        $this->tournament->winner_id = $this->players[0]->id;
        $this->tournament->date_end = now()->format('Y-m-d');
        $this->tournament->save();
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

}