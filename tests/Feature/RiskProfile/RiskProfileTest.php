<?php

namespace Tests\Feature\RiskProfile;

use App\Enums\ProfileEnum;
use App\Http\Middleware\AccessControlMiddleware;
use App\Http\Requests\InsuranceRequest;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Tests\TestCase;
use function env;

class RiskProfileTest extends TestCase
{
    private const ENDPOINT = 'api/insurance/risk';
    private static array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        self::$headers = [
            AccessControlMiddleware::API_KEY_HEADER_NAME => env('API_KEY'),
        ];
    }

    public function testRiskProfileintWithValidInputShouldReturnSuccess(): void
    {
        /** Arrange */
        $input = $this->getMockFile('valid-input.json');
        $expected = [
            'status_code' => Response::HTTP_OK,
            'output' => [
                'auto' => ProfileEnum::REGULAR,
                'disability' => ProfileEnum::INELIGIBLE,
                'home' => ProfileEnum::ECONOMIC,
                'life' => ProfileEnum::REGULAR,
            ],
        ];

        /** Act */
        $response = $this->post(self::ENDPOINT, $input, self::$headers);

        /** Assert */
        $response->assertStatus($expected['status_code']);
        $response->assertExactJson($expected['output']);
    }

    public function testRiskProfileWithInvalidInputShouldReturnError(): void
    {
        /** Arrange */
        $currentYear = Carbon::today()->year;
        $input = $this->getMockFile('invalid-input.json');
        $expected = [
            'status_code' => Response::HTTP_NOT_ACCEPTABLE,
            'output' => [
                'message' => trans('exceptions.invalid-params'),
                'error' => [
                    'age' => [
                        trans('validation.integer', ['attribute' => 'age']),
                        trans('validation.gte.numeric', ['attribute' => 'age', 'value' => InsuranceRequest::AGE_GTE]),
                    ],
                    'dependents' => [
                        trans('validation.required', ['attribute' => 'dependents']),
                    ],
                    'house.ownership_status' => [
                        trans('validation.string', ['attribute' => 'house.ownership status']),
                        trans('validation.enum', ['attribute' => 'house.ownership status']),
                    ],
                    'income' => [
                        trans('validation.integer', ['attribute' => 'income']),
                        trans('validation.gte.numeric', [
                            'attribute' => 'income',
                            'value' => InsuranceRequest::INCOME_GTE
                        ]),
                    ],
                    'marital_status' => [
                        trans('validation.required', ['attribute' => 'marital status']),
                    ],
                    'risk_questions' => [
                        trans('validation.size.array', [
                            'attribute' => 'risk questions',
                            'size' => InsuranceRequest::RISK_QUESTIONS_SIZE
                        ]),
                    ],
                    'vehicle.year' => [
                        trans('validation.integer', ['attribute' => 'vehicle.year']),
                        trans('validation.between.numeric', [
                            'attribute' => 'vehicle.year',
                            'min' => InsuranceRequest::FIRST_CAR_YEAR,
                            'max' => $currentYear
                        ]),
                    ],
                ]
            ],
        ];

        /** Act */
        $response = $this->post(self::ENDPOINT, $input, self::$headers);

        /** Assert */
        $response->assertStatus($expected['status_code']);
        $this->assertEquals($expected['output']['message'], $response->json('message'));
        $this->assertEquals($expected['output']['error'], $response->json('error'));
    }
}
