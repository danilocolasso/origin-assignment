<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\ProfilesDTO;
use App\Services\Risk\ScoreCalculators\VehicleRiskScore;
use Carbon\Carbon;

class VehicleRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider vehicleDataProvider */
    public function testUserWithDifferentVechicleYearsShouldChangeProfilesRespectively(int $year, array $expected): void
    {
        $this->input->vehicle->year = $year;
        $calculator = new VehicleRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        $this->assertEquals(new ProfilesDTO($expected), $this->profiles);
    }

    public function vehicleDataProvider(): array
    {
        return [
            'produced-last-5-years' => [
                'year' => Carbon::today()->subYears(5)->year,
                'expected' => [
                    'auto' => 1,
                    'disability' => 0,
                    'home' => 0,
                    'life' => 0,
                ],
            ],
            'produced-more-than-5-years-ago' => [
                'year' => Carbon::today()->subYears(6)->year,
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
