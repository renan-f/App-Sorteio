<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepstakeResult extends Model
{
    protected $table = 'sweepstake_result';

    protected $fillable = [
        'award_sweepstake_id',
        'participant_id',
        'active'
    ];
}
