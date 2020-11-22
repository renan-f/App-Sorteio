<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sweepstakes extends Model
{
    protected $table = 'sweepstakes';

    protected $fillable = [
        'user_id',
        'description',
        'active'
    ];
}
