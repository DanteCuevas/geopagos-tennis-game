<?php

namespace Tests\Feature;

use App\Models\Tournaments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TournamentTest extends TestCase
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

    public function test_tournaments_get_with_paginate()
    {

        $response = $this->json('GET', route('tournaments.index'), $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*'     => [
                    'id', 'date_start', 'date_end', 'gender', 'winner_id',
                    'winner' => [
                        'id', 'first_name', 'last_name', 'gender'
                    ]
                ]
            ],
            'meta'  => [
                'current_page', 'from', 'last_page', 'per_page', 'to', 'total'
            ]
        ]);

    }

    public function test_tournaments_game()
    {

        $response = $this->json('POST', route('tournaments.game'), [], $this->headers);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                'id', 'date_start', 'date_end', 'gender', 'winner_id',
                'winner' => [
                    'id', 'first_name', 'last_name', 'gender'
                ]
            ]
        ]);

    }

    public function test_tournaments_show()
    {
        $response = $this->json('POST', route('tournaments.game'), [], $this->headers);
        $tournament_id = $response->getData()->data->id;

        $response = $this->json('GET', route('tournaments.show', $tournament_id), $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                'id', 'date_start', 'date_end', 'gender', 'winner_id',
                'winner' => [
                    'id', 'first_name', 'last_name', 'gender'
                ]
            ]
        ]);

    }

    public function test_tournaments_show_validate_id()
    {

        $response = $this->json('GET', route('tournaments.show', 0), $this->headers);
        $response->assertStatus(404);
        $response->assertJson([
            "message"   => "Tournament does not exist"
        ]);

    }

}
