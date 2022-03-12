<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\AccessControlMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class AccessControlMiddlewareTest extends TestCase
{
    private const ENDPOINT = 'api/insurance/risk';

    public function testRiskProfileWithoutApiKeyHeaderShouldReturnMissingApiKey(): void
    {
        /** Arrange */
        $expected = [
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'output' => [
                'message' => trans('exceptions.missing-api-key'),
                'error' => 'Unauthorized',
            ],
        ];

        /** Act */
        $response = $this->post(self::ENDPOINT);

        /** Assert */
        $response->assertStatus($expected['status_code']);
        $response->assertExactJson($expected['output']);
    }

    public function testRiskProfileWithInvalidApiKeyHeaderShouldReturnInvalidApiKey(): void
    {
        /** Arrange */
        $expected = [
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'output' => [
                'message' => trans('exceptions.invalid-api-key'),
                'error' => 'Unauthorized',
            ],
        ];
        $input = [];
        $headers = [
            AccessControlMiddleware::API_KEY_HEADER_NAME => 'Some invalid x-api-key',
        ];

        /** Act */
        $response = $this->post(self::ENDPOINT, $input, $headers);

        /** Assert */
        $response->assertStatus($expected['status_code']);
        $response->assertExactJson($expected['output']);
    }
}
