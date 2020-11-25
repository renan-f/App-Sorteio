<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SweepstakesService;

class SweepstakesController extends Controller
{
    private $sweepstakesService;

    public function __construct(SweepstakesService $sweepstakesService)
    {
        $this->sweepstakesService = $sweepstakesService;
    }

    public function getAll()
    {
        return $this->sweepstakesService->getAll();
    }

    public function get($id)
    {
        return $this->sweepstakesService->get($id);
    }

    public function getAllForUser($idUser)
    {
        return $this->sweepstakesService->getAllForUser($idUser);
    }

    public function store(Request $request)
    {
        return $this->sweepstakesService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->sweepstakesService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->sweepstakesService->destroy($id);
    }
}
