<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Participants extends Model
{
    protected $table = 'participants';

    protected $fillable = [
        'sweepstakes_id',
        'name',
        'email',
        'active'
    ];
}
