<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Enums\ProfileEnum;
use App\Services\Risk\ScoreCalculators\AgeRiskScore;

class AgeRiskScoreTest extends RiskScoreTestCase
{
    public function testUserOverSixty(): void
    {
        $expected = [
            'disability' => ProfileEnum::IMMUTABLE,
            'life' => ProfileEnum::IMMUTABLE,
        ];

        $this->input->age = 61;
        $calculator = new AgeRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals($expected['disability'], $this->profiles->disability);
        $this->assertEquals($expected['life'], $this->profiles->life);
    }

    /** @dataProvider ageDataProvider */
    public function testCalculateWithDifferentAgesUnderSixtyShouldChangeProfilesRespectively(int $age, array $expected): void
    {
        $this->input->age = $age;
        $calculator = new AgeRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function ageDataProvider(): array
    {
        return [
            'under-30-yo' => [
                'age' => 29,
                'expected' => [
                    'auto' => -2,
                    'disability' => -2,
                    'home' => -2,
                    'life' => -2,
                ],
            ],
            'between-30-40-yo' => [
                'age' => 35,
                'expected' => [
                    'auto' => -1,
                    'disability' => -1,
                    'home' => -1,
                    'life' => -1,
                ],
            ],
            'above-40-yo' => [
                'age' => 41,
                'expected' => [
                    'auto' => 0,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
        ];
    }
}
