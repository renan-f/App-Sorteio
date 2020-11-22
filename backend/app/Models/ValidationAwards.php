<?php

namespace App\Models;

class ValidationAwards
{
    const RULE_AWARD = [
        'user_id' => 'required',
        'name' => 'required | max:255 | min:2'
    ];
}
