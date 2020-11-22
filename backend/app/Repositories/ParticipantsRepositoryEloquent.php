<?php

namespace App\Repositories;

use App\Repositories\ParticipantsRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Participants;


class ParticipantsRepositoryEloquent implements ParticipantsRepositoryInterface
{
    private $model;

    public function __construct(Participants $participants)
    {
        $this->model = $participants;
    }

    public function getAllForSweepstake($idSweepstake)
    {
        return $participants = $this->model->where('sweepstakes_id', '=', $idSweepstake)->where('active', '=', 1)->get();
    }

    public function get($id)
    {
        return $participants = $this->model->where('active', '=', 1)->find($id);
    }

    public function store(Request $request)
    {
        return $participants = $this->model->create($request->all());
    }
}
