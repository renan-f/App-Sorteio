<?php

namespace App\Models;

class ValidationUsers
{
    const RULE_USER = [
        'name' => 'required | max:255 | min:3',
        'email' => 'required | max:255 | min:5',
        'password' => 'required | min:8'
    ];
}
