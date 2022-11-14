<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'skill',
        'strength',
        'speed',
        'reaction'
    ];

    public function scopeGender($query, $value)
    {
        return  $query->when($value, function ($query) use ($value) {
                    $query->where('gender', $value);
                });
    }

}
