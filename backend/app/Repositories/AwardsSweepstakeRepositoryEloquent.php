<?php

namespace App\Repositories;

use App\Repositories\AwardsSweepstakeRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\AwardsSweepstake;


class AwardsSweepstakeRepositoryEloquent implements AwardsSweepstakeRepositoryInterface
{
    private $model;

    public function __construct(AwardsSweepstake $awardsSweepstake)
    {
        $this->model = $awardsSweepstake;
    }


    public function store(Request $request)
    {
        return $awards = $this->model->create($request->all());
    }
}
