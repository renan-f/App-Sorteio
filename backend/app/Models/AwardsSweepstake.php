<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AwardsSweepstake extends Model
{
    protected $table = 'awards_sweepstakes';

    protected $fillable = [
        'award_id',
        'sweepstakes_id'
    ];
}
