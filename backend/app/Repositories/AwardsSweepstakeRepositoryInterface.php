<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface AwardsSweepstakeRepositoryInterface
{
    public function store(Request $request);
}
