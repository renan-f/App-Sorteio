<?php

namespace App\Models;

class ValidationParticipants
{

    const RULE_PARTICIPANTS = [
        'sweepstakes_id' => 'required',
        'name' => 'required | max:255 | min:2',
        'email' => 'required | max:255 | min:5'
    ];
}
