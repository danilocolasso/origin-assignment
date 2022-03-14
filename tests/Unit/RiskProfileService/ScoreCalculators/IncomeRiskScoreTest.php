<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Services\Risk\ScoreCalculators\IncomeRiskScore;

class IncomeRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider incomeDataProvider */
    public function testUserWithDifferentIncomesShouldChangeProfilesRespectively(int $income, array $expected): void
    {
        $this->input->income = $income;
        $calculator = new IncomeRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function incomeDataProvider(): array
    {
        return [
            'less-than-equals-200k' => [
                'income' => 200000,
                'expected' => [
                    'auto' => 0,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
            'above-200k' => [
                'income' => 200001,
                'expected' => [
                    'auto' => -1,
                    'disability' => -1,
                    'home' => -1,
                    'life' => -1,
                ],
            ],
        ];
    }
}
