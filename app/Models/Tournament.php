<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    protected $fillable = [
        'date_start',
        'date_end',
        'gender',
        'winner_id'
    ];

    protected $casts = [
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'date_start'    => 'date',
        'date_end'      => 'date'
    ];

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'tournament_id');
    }

    public function scopeDateStart($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->where('date_start', $value);
                });
    }

    public function scopeDateEnd($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->where('date_end', $value);
                });
    }

    public function scopeGender($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->where('gender', $value);
                });
    }

    public function scopeWinnerId($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->where('winner_id', $value);
                });
    }

    public function scopeFilterWinner($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->whereHas('winner', function ($query) use ($value) {
                        $query->where('first_name', 'LIKE', '%'.$value.'%');
                    });
                });
    }

}
