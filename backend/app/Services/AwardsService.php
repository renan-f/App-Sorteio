<?php

namespace App\Services;

use App\Models\ValidationAwards;
use App\Repositories\AwardsRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AwardsService
{
    private $awardsRepository;

    public function __construct(AwardsRepositoryInterface $awardsRepository)
    {
        $this->awardsRepository = $awardsRepository;
    }

    public function getAll()
    {
        try {
            $awards = $this->awardsRepository->getAll();

            if (count($awards) > 0) {
                return response()->json($awards, Response::HTTP_OK);
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
            $awards = [
                $this->awardsRepository->get($id)
            ];

            return count($awards) > 0 ? response()->json($awards, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllForUser($idUser)
    {

        try {
            $awards = $this->awardsRepository->getAllForUser($idUser);
            return count($awards) > 0 ? response()->json($awards, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAwardsForUserInSweepstake($idUser)
    {
        try {
            $awards = $this->awardsRepository->getAwardsForUserInSweepstake($idUser);
            return count($awards) > 0 ? response()->json($awards, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationAwards::RULE_AWARD
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $award = $this->awardsRepository->store($request);

                return response()->json($award, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function update($id, Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            ValidationAwards::RULE_AWARD
        );


        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $award = $this->awardsRepository->update($id, $request);
                return response()->json($award, Response::HTTP_OK);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        try {
            $award = $this->awardsRepository->destroy($id);
            return response()->json($award, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
