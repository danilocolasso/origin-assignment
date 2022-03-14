<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\HouseDTO;
use App\DTO\VehicleDTO;
use App\Enums\ProfileEnum;
use App\Services\Risk\ScoreCalculators\InelegibleRiskScore;

class InelegibleRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider ineligibleDataProvider */
    public function testUserWithDifferentVechicleYearsShouldChangeProfilesRespectively(array $input, array $expected): void
    {
        foreach ($input as $key => $value) {
            $this->input->$key = $value;
        }

        $calculator = new InelegibleRiskScore($this->profiles, $this->input);
        $calculator->calculate();

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $this->profiles->$key);
        }
    }

    public function ineligibleDataProvider(): array
    {
        return [
            'no-houses' => [
                'input' => [
                    'house' => new HouseDTO(),
                ],
                'expected' => [
                    'home' => ProfileEnum::IMMUTABLE,
                ],
            ],
            'no-income' => [
                'input' => [
                    'income' => 0,
                ],
                'expected' => [
                    'disability' => ProfileEnum::IMMUTABLE,
                ],
            ],
            'no-vehicle' => [
                'input' => [
                    'vehicle' => new VehicleDTO(),
                ],
                'expected' => [
                    'auto' => ProfileEnum::IMMUTABLE,
                ],
            ],
        ];
    }
}
