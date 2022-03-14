<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Services\Risk\ScoreCalculators\DependentsRiskScore;

class DependentsRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider dependentsDataProvider */
    public function testUserWithDifferentNumberOfDependentsShouldChangeProfilesRespectively(int $dependents, array $expected): void
    {
        $this->input->dependents = $dependents;
        $calculator = new DependentsRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function dependentsDataProvider(): array
    {
        return [
            'none' => [
                'dependents' => 0,
                'expected' => [
                    'auto' => 0,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
            'one-or-more' => [
                'dependents' => 2,
                'expected' => [
                    'auto' => 0,
                    'disability' => 1,
                    'home' => 0,
                    'life' => 1,
                ],
            ],
        ];
    }
}
