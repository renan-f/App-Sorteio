<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SortearService;


class SortearController extends Controller
{
    private $sortearService;

    public function __construct(SortearService $sortearService)
    {
        $this->sortearService = $sortearService;
    }

    public function getAllForSweepstakeAndAward(Request $request)
    {
        return $this->sortearService->getAllForSweepstakeAndAward($request);
    }
}
