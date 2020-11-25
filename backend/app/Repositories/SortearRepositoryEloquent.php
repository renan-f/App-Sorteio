<?php

namespace App\Repositories;

use App\Repositories\SortearRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\AwardsSweepstake;


class SortearRepositoryEloquent implements SortearRepositoryInterface
{
    private $model;

    public function __construct(AwardsSweepstake $sortear)
    {
        $this->model = $sortear;
    }

    public function getAllForSweepstakeAndAward(Request $request)
    {
        // return $request->sweepstakes_id;

        return $award_sweepstake = $this->model
            ->where('sweepstakes_id', '=', $request->sweepstakes_id)
            ->where('award_id', '=', $request->award_id)
            ->where('active', '=', 1)
            ->get();
    }
}
