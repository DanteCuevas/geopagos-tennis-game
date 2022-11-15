<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     title="Tournament",
 *     description="Model of tournament",
 *     @OA\Xml(
 *         name="Tournament"
 *     ),
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          title="Id",
 *          description="id",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="gender",
 *          type="string",
 *          title="Gender",
 *          description="Gender (male/female)",
 *          example="male"
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          format="date",
 *          type="string",
 *          title="Date start",
 *          description="Date start",
 *          example="2022-01-01"
 *      ),
 *      @OA\Property(
 *          property="date_end",
 *          format="date",
 *          type="string",
 *          title="Date end",
 *          description="Date end",
 *          example="2022-01-01"
 *      ),
 *      @OA\Property(
 *          property="winner_id",
 *          type="integer",
 *          title="Winner id",
 *          description="Winner id",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          format="date-time",
 *          type="string",
 *          title="Created at",
 *          description="Created at",
 *          example="2022-01-01 00:00:00"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          format="date-time",
 *          type="string",
 *          title="Updated at",
 *          description="Updated at",
 *          example="2022-01-01 00:00:00"
 *      )
 * )
 */
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
