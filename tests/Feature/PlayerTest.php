<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Str;

class PlayerTest extends TestCase
{
    use WithFaker;
    private $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->headers = [
            'Accept'    => 'application/json'
        ];
    }
    
    public function test_player_create_success()
    {
        $gender = $this->faker->randomElement(['male' , 'female']);
        $first_name = $gender === 'male' ? $this->faker->firstNameMale() : $this->faker->firstNameFemale();

        $body = [
            'first_name'    => $first_name,
            'last_name'     => $this->faker->lastName(),
            'gender'        => $gender,
            'skill'         => $this->faker->numberBetween(0, 100),
            'strength'      => $this->faker->numberBetween(0, 100),
            'speed'         => $this->faker->numberBetween(0, 100),
            'reaction'      => $this->faker->numberBetween(0, 100)
        ];
        $response = $this->json('POST', route('players.store'), $body, $this->headers);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'first_name', 'last_name', 'gender', 'skill', 'strength', 'speed', 'reaction'
        ]);

        // DELETE ONLY FOR HAVE 2^N PLAYERS
        $player = Player::find($response->getData()->id);
        $player->delete();
    }

    public function test_player_create_request_required()
    {
        
        $response = $this->json('POST', route('players.store'), [], $this->headers);
        $response->assertStatus(422);
        $response->assertJson([
            "message"   => "The given data was invalid.",
            "errors"    => [
                "first_name"    => ["The first name field is required."],
                "last_name"     => ["The last name field is required."],
                "gender"        => ["The gender field is required."],
                "skill"         => ["The skill field is required."],
                "strength"      => ["The strength field is required."],
                "speed"         => ["The speed field is required."],
                "reaction"      => ["The reaction field is required."],
            ]
        ]);

    }

    public function test_player_create_request_rules()
    {

        $body = [
            'first_name'    => Str::random(51),
            'last_name'     => Str::random(51),
            'gender'        => 'none',
            'skill'         => 101,
            'strength'      => 101,
            'speed'         => 101,
            'reaction'      => 101
        ];
        $response = $this->json('POST', route('players.store'), $body, $this->headers);
        $response->assertStatus(422);
        $response->assertJson([
            "message"   => "The given data was invalid.",
            "errors"    => [
                "first_name"    => ["The first name must not be greater than 50 characters."],
                "last_name"     => ["The last name must not be greater than 50 characters."],
                "gender"        => ["The selected gender is invalid."],
                "skill"         => ["The skill must not be greater than 100."],
                "strength"      => ["The strength must not be greater than 100."],
                "speed"         => ["The speed must not be greater than 100."],
                "reaction"      => ["The reaction must not be greater than 100."],
            ]
        ]);

    }

    public function test_players_get_with_paginate()
    {

        $response = $this->json('GET', route('players.index'), $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*'     => [
                    'id', 'first_name', 'last_name', 'gender', 'skill', 'strength', 'speed', 'reaction'
                ]
            ],
            'meta'  => [
                'current_page', 'from', 'last_page', 'per_page', 'to', 'total'
            ]
        ]);

    }

}
