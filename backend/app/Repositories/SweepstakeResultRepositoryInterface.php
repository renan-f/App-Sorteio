<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface SweepstakeResultRepositoryInterface
{
    public function getAllForSweepstake($idSweepstake);
    public function store(Request $request);
}
