<?php

namespace App\Services;

use App\Models\ValidationParticipants;
use App\Repositories\ParticipantsRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ParticipantsService
{
    private $participantsRepository;

    public function __construct(ParticipantsRepositoryInterface $participantsRepository)
    {
        $this->participantsRepository = $participantsRepository;
    }

    public function get($id)
    {

        try {
            $participants = [
                $this->participantsRepository->get($id)
            ];

            return count($participants) > 0 ? response()->json($participants, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllForSweepstake($idSweepstake)
    {

        try {
            $participants = $this->participantsRepository->getAllForSweepstake($idSweepstake);
            return count($participants) > 0 ? response()->json($participants, Response::HTTP_OK) : response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationParticipants::RULE_PARTICIPANTS
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $participant = $this->participantsRepository->store($request);
                return response()->json($participant, Response::HTTP_CREATED);


                return response()->json($participant, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
