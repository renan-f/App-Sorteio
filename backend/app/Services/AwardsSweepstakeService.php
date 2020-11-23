<?php

namespace App\Services;

use App\Models\ValidationAwardsSweepstake;
use App\Repositories\AwardsSweepstakeRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AwardsSweepstakeService
{
    private $awardsSweepstakeRepository;

    public function __construct(AwardsSweepstakeRepositoryInterface $awardsSweepstakeRepository)
    {
        $this->awardsSweepstakeRepository = $awardsSweepstakeRepository;
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationAwardsSweepstake::RULE_AWARDSSWEEPSTAKE
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $awardsSweepstake = $this->awardsSweepstakeRepository->store($request);

                return response()->json($awardsSweepstake, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro no Banco'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
