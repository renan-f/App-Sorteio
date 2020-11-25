<?php

namespace App\Services;

use App\Models\ValidationSortear;
use App\Repositories\SortearRepositoryInterface;
use App\Repositories\ParticipantsRepositoryInterface;
use App\Repositories\SweepstakeResultRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SortearService
{
    private $sortearRepository;
    private $participantsRepository;
    private $sweepstakeResultRepositoryInterface;

    public function __construct(SortearRepositoryInterface $sortearRepository, ParticipantsRepositoryInterface $participantsRepository, SweepstakeResultRepositoryInterface $sweepstakeResultRepositoryInterface)
    {
        $this->sortearRepository = $sortearRepository;
        $this->participantsRepository = $participantsRepository;
        $this->sweepstakeResultRepositoryInterface = $sweepstakeResultRepositoryInterface;
    }

    public function getAllForSweepstakeAndAward(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationSortear::RULE_SORTEAR
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $award_sweepstake = $this->sortearRepository->getAllForSweepstakeAndAward($request);
                $participants = $this->participantsRepository->getAllForSweepstake($award_sweepstake[0]->sweepstakes_id);
                $indexGanhador = rand(0, count($participants) - 1);

                $ganhador = [
                    "award_sweepstake_id" => $award_sweepstake[0]->id,
                    "participant_id" => $participants[$indexGanhador]->id
                ];

                $ganhadorCadastrado = $this->sweepstakeResultRepositoryInterface->store(new Request($ganhador));

                return response()->json($ganhadorCadastrado, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
