<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SweepstakeResultService;

class SweepstakeResultController extends Controller
{
    private $sweepstakeresultservice;

    public function __construct(SweepstakeResultService $sweepstakeresultservice)
    {
        $this->sweepstakeresultservice = $sweepstakeresultservice;
    }

    public function getAllForSweepstake($idSweepstake)
    {
        return $this->sweepstakeresultservice->getAllForSweepstake($idSweepstake);
    }

    public function store(Request $request)
    {
        return $this->sweepstakeresultservice->store($request);
    }
}
