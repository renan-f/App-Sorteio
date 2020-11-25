<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface SortearRepositoryInterface
{
    public function getAllForSweepstakeAndAward(Request $request);
}
