<?php

namespace App\Services;

use App\Models\ValidationSweepstakes;
use App\Repositories\SweepstakesRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SweepstakesService
{
    private $sweepstakesRepository;

    public function __construct(SweepstakesRepositoryInterface $sweepstakesRepository)
    {
        $this->sweepstakesRepository = $sweepstakesRepository;
    }

    public function getAll()
    {
        try {
            $sweepstakes = $this->sweepstakesRepository->getAll();

            if (count($sweepstakes) > 0) {
                return response()->json($sweepstakes, Response::HTTP_OK);
            } else {
                return response()->json([], Response::HTTP_OK);
            }
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get($id)
    {

        try {
            $sweepstakes = [
                $this->sweepstakesRepository->get($id)
            ];

            return count($sweepstakes) > 0 ? response()->json($sweepstakes, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllForUser($idUser)
    {

        try {
            $sweepstakes = $this->sweepstakesRepository->getAllForUser($idUser);
            return count($sweepstakes) > 0 ? response()->json($sweepstakes, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationSweepstakes::RULE_SWEEPSTAKES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $sweepstake = $this->sweepstakesRepository->store($request);

                return response()->json($sweepstake, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function update($id, Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            ValidationSweepstakes::RULE_SWEEPSTAKES
        );


        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $sweepstake = $this->sweepstakesRepository->update($id, $request);
                return response()->json($sweepstake, Response::HTTP_OK);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        try {
            $sweepstake = $this->sweepstakesRepository->destroy($id);
            return response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
