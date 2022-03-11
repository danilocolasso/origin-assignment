<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceRequest;
use App\Http\Services\RiskProfileService;
use Illuminate\Http\JsonResponse;

class InsuranceController extends Controller
{
    public function risk(InsuranceRequest $request): JsonResponse
    {
        $riskProfileService = new RiskProfileService($request->all());

        return response()->json($riskProfileService->calculate());
    }


}
