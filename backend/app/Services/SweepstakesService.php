<?php

namespace App\Services;

use App\Models\ValidationSweepstakes;
use App\Repositories\SweepstakesRepositoryInterface;
use App\Repositories\AwardsRepositoryInterface;
use App\Repositories\SweepstakeResultRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SweepstakesService
{
    private $sweepstakesRepository;
    private $awardsRepository;
    private $sweepstakeResultRepository;

    public function __construct(SweepstakesRepositoryInterface $sweepstakesRepository, AwardsRepositoryInterface $awardsRepository, SweepstakeResultRepositoryInterface $sweepstakeResultRepository)
    {
        $this->sweepstakesRepository = $sweepstakesRepository;
        $this->awardsRepository = $awardsRepository;
        $this->sweepstakeResultRepository = $sweepstakeResultRepository;
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
            $awardsSweepstakes = $this->awardsRepository->getAwardsForUserInSweepstake($idUser);

            foreach ($sweepstakes as $sweepstake) {
                $awards = array();
                foreach ($awardsSweepstakes as $awardsSweepstake) {
                    if ($awardsSweepstake->sweepstakes_id == $sweepstake->id) {
                        array_push($awards, $awardsSweepstake);
                    }
                }

                $sweepstakeResults = $this->sweepstakeResultRepository->getAllForSweepstake($sweepstake->id);
                foreach ($awards as $award) {
                    $result = array();
                    foreach ($sweepstakeResults as $sweepsResult) {
                        if ($award->award_id == $sweepsResult->award_id) {
                            array_push($result, $sweepsResult);
                        }
                    }
                    $award->results = $result;
                }
                $sweepstake->awards = $awards;
            }
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
