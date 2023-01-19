<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liner extends Model
{
    use HasFactory;

    protected $table = 'liners';

    protected $fillable = [
        'code_report',
        'code',
        'date_report',
        'status',
        'location',
        'orden',
    ];
}
