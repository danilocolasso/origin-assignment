<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Enums\HouseEnum;
use App\Services\Risk\ScoreCalculators\HouseRiskScore;

class HouseRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider houseOwnershipStatusDataProvider */
    public function testUserWithDifferentHouseOwnershipStatusShouldChangeProfilesRespectively(string $ownershipStatus, array $expected): void
    {
        $this->input->house->ownershipStatus = $ownershipStatus;
        $calculator = new HouseRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function houseOwnershipStatusDataProvider(): array
    {
        return [
            'owned' => [
                'ownership_status' => HouseEnum::OWNED,
                'expected' => [
                    'auto' => 0,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
            'mortgaged' => [
                'ownership_status' => HouseEnum::MORTGAGED,
                'expected' => [
                    'auto' => 0,
                    'disability' => 1,
                    'home' => 1,
                    'life' => 0,
                ],
            ],
        ];
    }
}
