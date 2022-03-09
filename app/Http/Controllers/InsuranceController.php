<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceRequest;
use Illuminate\Http\JsonResponse;

class InsuranceController extends Controller
{
    public function risk(InsuranceRequest $request): JsonResponse
    {
        return response()->json($request->all());
    }
}
