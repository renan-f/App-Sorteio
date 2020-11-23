<?php

namespace App\Repositories;

use App\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Users;


class UsersRepositoryEloquent implements UsersRepositoryInterface
{
    private $model;

    public function __construct(Users $users)
    {
        $this->model = $users;
    }

    public function getAll()
    {
        // return $users = $this->model->all();
        return $users = $this->model->where('active', '!=', 0)->get();
    }
    public function get($id)
    {
        return $users = $this->model->where('active', '!=', 0)->find($id);
    }

    public function login(Request $request)
    {
        $user = $this->model
            ->where('email', '=', $request->email)
            ->where('password', '=', $request->password)
            ->where('active', '=', '1')
            ->get();

        return count($user) > 0 ? $user[0] : ["result" => "false"];
    }

    public function store(Request $request)
    {
        return $user = $this->model->create($request->all());
    }
    public function update($id, Request $request)
    {
        $user = $this->model
            ->where('active', '=', '1')
            ->where('id', '=', $id)
            ->get();

        return count($user) > 0 ? ["result" => $user[0]->update($request->all())] : ["result" => false];
    }

    public function destroy($id)
    {
        $user = $this->model
            ->where('active', '=', '1')
            ->where('id', '=', $id)
            ->get();
        return count($user) > 0 ? ["result" => $user[0]->update(["active" => 0])] : ["result" => false];
    }
}
