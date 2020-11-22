<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParticipantsService;

class ParticipantsController extends Controller
{
    private $participantsService;

    public function __construct(ParticipantsService $participantsService)
    {
        $this->participantsService = $participantsService;
    }

    public function get($id)
    {
        return $this->participantsService->get($id);
    }

    public function getAllForSweepstake($idSweepstake)
    {
        return $this->participantsService->getAllForSweepstake($idSweepstake);
    }

    public function store(Request $request)
    {
        return $this->participantsService->store($request);
    }
}
