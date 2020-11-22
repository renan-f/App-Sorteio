<?php

namespace App\Services;

use App\Models\SweepstakeResult;
use App\Models\ValidationSweepstakeResult;
use App\Repositories\SweepstakeResultRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SweepstakeResultService
{
    private $sweepstakeresulRepository;

    public function __construct(SweepstakeResultRepositoryInterface $sweepstakeresulRepository)
    {
        $this->sweepstakeresulRepository = $sweepstakeresulRepository;
    }


    public function getAllForSweepstake($idSweepstake)
    {

        try {
            $sweepstakeresult = $this->sweepstakeresulRepository->getAllForSweepstake($idSweepstake);
            return count($sweepstakeresult) > 0 ? response()->json($sweepstakeresult, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationSweepstakeResult::RULE_SWEEPSTAKE_RESULT
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $sweepstakeresult = $this->sweepstakeresulRepository->store($request);
                return response()->json($sweepstakeresult, Response::HTTP_CREATED);


                return response()->json($sweepstakeresult, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
