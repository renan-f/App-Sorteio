<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface AwardsRepositoryInterface
{
    public function getAll();
    public function get($id);
    public function getAllForUser($idUser);
    public function getAwardsForUserInSweepstake($idUser);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
