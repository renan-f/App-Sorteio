<?php

namespace App\Models;

class ValidationSweepstakes
{

    const RULE_SWEEPSTAKES = [
        'user_id' => 'required',
        'description' => 'required | max:255 | min:2'
    ];
}
