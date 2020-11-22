<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ParticipantsRepositoryInterface
{
    public function getAllForSweepstake($idSweepstake);
    public function get($id);
    public function store(Request $request);
}
