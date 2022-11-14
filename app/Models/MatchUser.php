<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchUser extends Model
{
    use HasFactory;

    protected $table = 'match_users';

    protected $fillable = [
        'schedule_id',
        'player_one_id',
        'player_two_id',
        'date_start',
        'winner',
    ];

    public function player_one(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_one_id');
    }

    public function player_two(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_two_id');
    }

}
