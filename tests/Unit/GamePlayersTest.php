<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GameService;
use App\Models\Player;

class GamePlayersTest extends TestCase
{

    private $highSkills;
    private $lowSkills;

    protected function setUp(): void
    {
        parent::setUp();
        $this->highSkills = ['skill' => 100, 'strength' => 100, 'speed' => 100, 'reaction' => 100];
        $this->lowSkills = ['skill' => 1, 'strength' => 1, 'speed' => 1, 'reaction' => 1];
    }

    public function test_get_winner_male_with_high_skills()
    {
        $playerOne = Player::factory()->male()->create($this->highSkills);
        $playerTwo = Player::factory()->male()->create($this->lowSkills);

        $gameService = new GameService($playerOne, $playerTwo);
        $gameResult = $gameService->play()->getResult();

        $this->assertEquals($playerOne, $gameResult->player_winner);

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $playerOne->delete();
        $playerTwo->delete();
    }

    public function test_get_winner_male_by_luck()
    {
        $playerOne = Player::factory()->male()->create($this->highSkills);
        $playerTwo = Player::factory()->male()->create($this->highSkills);

        $gameService = new GameService($playerOne, $playerTwo);
        $gameResult = $gameService->play()->getResult();

        $this->assertContains($gameResult->player_winner, [$playerOne, $playerTwo]);

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $playerOne->delete();
        $playerTwo->delete();
    }

    public function test_get_winner_female_with_high_skills()
    {
        $playerOne = Player::factory()->female()->create($this->highSkills);
        $playerTwo = Player::factory()->female()->create($this->lowSkills);

        $gameService = new GameService($playerOne, $playerTwo);
        $gameResult = $gameService->play()->getResult();

        $this->assertEquals($playerOne, $gameResult->player_winner);

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $playerOne->delete();
        $playerTwo->delete();
    }

    public function test_get_winner_female_by_luck()
    {
        $playerOne = Player::factory()->female()->create($this->highSkills);
        $playerTwo = Player::factory()->female()->create($this->highSkills);

        $gameService = new GameService($playerOne, $playerTwo);
        $gameResult = $gameService->play()->getResult();

        $this->assertContains($gameResult->player_winner, [$playerOne, $playerTwo]);

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $playerOne->delete();
        $playerTwo->delete();
    }

}
