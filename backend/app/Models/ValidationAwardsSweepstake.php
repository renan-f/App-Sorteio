<?php

namespace App\Models;

class ValidationAwardsSweepstake
{

    const RULE_AWARDSSWEEPSTAKE = [
        'award_id' => 'required',
        'sweepstakes_id' => 'required'
    ];
}
