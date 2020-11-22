<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AwardsService;


class AwardsController extends Controller
{
    private $awardsService;

    public function __construct(AwardsService $awardsService)
    {
        $this->awardsService = $awardsService;
    }
    public function getAll()
    {
        return $this->awardsService->getAll();
    }

    public function get($id)
    {
        return $this->awardsService->get($id);
    }

    public function getAllForUser($idUser)
    {
        return $this->awardsService->getAllForUser($idUser);
    }

    public function store(Request $request)
    {
        return $this->awardsService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->awardsService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->awardsService->destroy($id);
    }
}
