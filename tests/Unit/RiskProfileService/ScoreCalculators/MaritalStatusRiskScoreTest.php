<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Enums\MaritalStatusEnum;
use App\Services\Risk\ScoreCalculators\MaritalStatusRiskScore;

class MaritalStatusRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider maritalStatusDataProvider */
    public function testUserWithDifferentMaritalStatusShouldChangeProfilesRespectively(string $maritalStatus, array $expected): void
    {
        $this->input->maritalStatus = $maritalStatus;
        $calculator = new MaritalStatusRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function maritalStatusDataProvider(): array
    {
        return [
            'single' => [
                'marital_status' => MaritalStatusEnum::SINGLE,
                'expected' => [
                    'auto' => 0,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
            'married' => [
                'marital_status' => MaritalStatusEnum::MARRIED,
                'expected' => [
                    'auto' => 0,
                    'disability' => -1,
                    'home' => 0,
                    'life' => 1,
                ],
            ],
        ];
    }
}
