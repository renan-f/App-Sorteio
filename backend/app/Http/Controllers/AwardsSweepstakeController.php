<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AwardsSweepstakeService;

class AwardsSweepstakeController extends Controller
{
    private $awardsSweepstakeService;

    public function __construct(AwardsSweepstakeService $awardsSweepstakeService)
    {
        $this->awardsSweepstakeService = $awardsSweepstakeService;
    }

    public function store(Request $request)
    {
        return $this->awardsSweepstakeService->store($request);
    }
}
