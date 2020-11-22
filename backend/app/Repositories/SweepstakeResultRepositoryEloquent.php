<?php

namespace App\Repositories;

use App\Repositories\SweepstakeResultRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\SweepstakeResult;


class SweepstakeResultRepositoryEloquent implements SweepstakeResultRepositoryInterface
{
    private $model;

    public function __construct(SweepstakeResult $sweepstakeresult)
    {
        $this->model = $sweepstakeresult;
    }

    public function getAllForSweepstake($idSweepstake)
    {

        return $sweepstakeresult = $this->model
            ->join('awards_sweepstakes', 'sweepstake_result.award_sweepstake_id', '=', 'awards_sweepstakes.id')
            ->where('sweepstakes_id', '=', $idSweepstake)
            ->where('sweepstake_result.active', '=', 1)
            ->get();
    }


    public function store(Request $request)
    {
        return $sweepstakeresult = $this->model->create($request->all());
    }
}
