<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Support\Facades\Log;

class GameService {

    private $playerOne;
    private $playerTwo;
    private $player;
    private $result;
    private $powerDiff;

    public function __construct(Player $playerOne,Player $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->powerDiff = 5;
    }

    public function play(): GameService
    {
        $powerOne   = $this->power($this->playerOne);
        $powerTwo   = $this->power($this->playerTwo);
        $powerDiff  = abs($powerOne - $powerTwo);
        // FOR DEBUG PURPOSE
        Log::info($this->playerOne->id . ' VS ' . $this->playerTwo->id . ' : ' . $powerDiff);
        if($powerDiff <= $this->powerDiff)
            $this->setResult('luck');
        else if($powerOne > $powerTwo)
            $this->setResult('one');
        else if($powerOne < $powerTwo)
            $this->setResult('two');

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    private function power($player)
    {
        $this->player = $player;
        return $this->skill() + $this->strength() + $this->speed() + $this->reaction();
    }

    private function skill()
    {
        switch ($this->player->gender) {
            case 'male':
                return (65/100)*$this->player->skill;
                break;
            case 'female':
                return (45/100)*$this->player->skill;
                break;
            default:
                return 0;
                break;
        }
    }

    private function strength()
    {
        switch ($this->player->gender) {
            case 'male':
                return (40/100)*$this->player->strength;
                break;
            case 'female':
                return (25/100)*$this->player->strength;
                break;
            default:
                return 0;
                break;
        }
    }

    private function speed()
    {
        switch ($this->player->gender) {
            case 'male':
                return (20/100)*$this->player->speed;
                break;
            case 'female':
                return (15/100)*$this->player->speed;
                break;
            default:
                return 0;
                break;
        }
    }

    private function reaction()
    {
        switch ($this->player->gender) {
            case 'male':
                return (0/100)*$this->player->reaction;
                break;
            case 'female':
                return (45/100)*$this->player->reaction;
                break;
            default:
                return 0;
                break;
        }
    }

    private function setResult($winner)
    {
        $playerWinner;
        switch ($winner) {
            case 'one':
                $playerWinner = $this->playerOne;
                break;
            case 'two':
                $playerWinner = $this->playerTwo;
                break;
            case 'luck':
                $winner = rand(0,1) ? 'one' : 'two';
                $playerWinner = ($winner === 'one') ? $this->playerOne : $this->playerTwo;
                break;
        }
        $this->result = (object) [
            'player_one'    => $this->playerOne,
            'player_two'    => $this->playerTwo,
            'winner'        => $winner,
            'player_winner' => $playerWinner
        ];
    }

}