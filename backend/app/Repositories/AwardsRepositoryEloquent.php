<?php

namespace App\Repositories;

use App\Repositories\AwardsRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Awards;


class AwardsRepositoryEloquent implements AwardsRepositoryInterface
{
    private $model;

    public function __construct(Awards $awards)
    {
        $this->model = $awards;
    }

    public function getAll()
    {
        // return $users = $this->model->all();
        return $awards = $this->model->where('active', '=', 1)->get();
    }

    public function get($id)
    {
        return $awards = $this->model->where('active', '=', 1)->find($id);
    }

    public function getAllForUser($idUser)
    {
        return $awards = $this->model->where('user_id', '=', $idUser)->where('active', '=', 1)->get();
    }

    public function getAwardsForUserInSweepstake($idUser)
    {
        return $awards = $this->model
            ->join('awards_sweepstakes', 'awards.id', '=', 'awards_sweepstakes.award_id')
            ->join('sweepstakes', 'awards_sweepstakes.sweepstakes_id', '=', 'sweepstakes.id')
            ->where('sweepstakes.user_id', '=', $idUser)
            ->where('awards_sweepstakes.active', '=', 1)
            ->get();
    }




    public function store(Request $request)
    {
        return $awards = $this->model->create($request->all());
    }
    public function update($id, Request $request)
    {
        $awards = $this->model
            ->where('active', '=', '1')
            ->where('id', '=', $id)
            ->get();

        return count($awards) > 0 ? ["result" => $awards[0]->update($request->all())] : ["result" => false];
    }

    public function destroy($id)
    {

        $awards = $this->model
            ->where('active', '=', '1')
            ->where('id', '=', $id)
            ->get();

        return count($awards) > 0 ? ["result" => $awards[0]->update(["active" => 0])] : ["result" => false];
    }
}
