<?php

namespace App\Repositories;

use App\Repositories\SweepstakesRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Sweepstakes;


class SweepstakesRepositoryEloquent implements SweepstakesRepositoryInterface
{
    private $model;

    public function __construct(Sweepstakes $sweepstakes)
    {
        $this->model = $sweepstakes;
    }

    public function getAll()
    {
        // return $users = $this->model->all();
        return $sweepstakes = $this->model->where('active', '=', 1)->get();
    }

    public function get($id)
    {
        return $sweepstakes = $this->model->where('active', '=', 1)->find($id);
    }

    public function getAllForUser($idUser)
    {
        // return $users = $this->model->all();

        return $sweepstakes = $this->model->where('user_id', '=', $idUser)->where('active', '=', 1)->get();
    }

    public function store(Request $request)
    {
        return $sweepstakes = $this->model->create($request->all());
    }
    public function update($id, Request $request)
    {
        $sweepstakes = [$this->model->where('active', '=', 1)->find($id)];
        count($sweepstakes) > 0 ? $sweepstakes[0]->update($request->all()) : ["result" => "false"];
    }

    public function destroy($id)
    {

        $sweepstakes = [$this->model->find($id)];
        count($sweepstakes) > 0 ? $sweepstakes[0]->update(["active" => 0]) : ["result" => "false"];
        /*
        count($user) > 0 ? $user[0]->delete() : false;*/
    }
}
