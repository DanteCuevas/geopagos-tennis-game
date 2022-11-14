<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Requests\Player\PlayerStoreRequest;
use App\Http\Resources\Player\PlayerIndexCollection;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::orderBy('id')->paginate(32);
        return new PlayerIndexCollection($players);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerStoreRequest $request)
    {
        $player = Player::create($request->all());
        return response()->json($player, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return response()->json($player, 200);
    }

}
