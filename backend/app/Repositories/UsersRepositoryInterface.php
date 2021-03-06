<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UsersRepositoryInterface
{
    public function getAll();
    public function get($id);
    public function login(Request $request);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
