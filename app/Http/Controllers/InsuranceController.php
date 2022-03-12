<?php

namespace App\Http\Controllers;

use App\DTO\InputDTO;
use App\Http\Requests\InsuranceRequest;
use App\Services\Risk\RiskProfileService;
use Illuminate\Http\JsonResponse;

class InsuranceController extends Controller
{
    public function calculateRiskProfile(InsuranceRequest $request): JsonResponse
    {
        $input = new InputDTO($request->all());
        $riskProfileService = new RiskProfileService($input);

        return response()->json($riskProfileService->calculate());
    }
}
