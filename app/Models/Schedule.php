<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'tournament_id',
        'number',
        'date_start'
    ];

    public function match_users(): HasMany
    {
        return $this->hasMany(MatchUser::class, 'schedule_id');
    }

}
