<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\DTO\HouseDTO;
use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;
use App\DTO\VehicleDTO;
use Tests\TestCase;

class RiskScoreTestCase extends TestCase
{
    protected ProfilesDTO $profiles;
    protected InputDTO $input;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setBaseInputForTest();
        $this->setBaseProfilesForTest();
    }

    private function setBaseProfilesForTest(): void
    {
        $this->profiles = new ProfilesDTO(
            auto: 0,
            disability: 0,
            home: 0,
            life: 0,
        );
    }

    private function setBaseInputForTest(): void
    {
        $this->input = new InputDTO(
            age: 35,
            dependents: 2,
            house: new HouseDTO(ownership_status: 'owned'),
            income: 0,
            marital_status: 'married',
            risk_questions: [0, 1, 0],
            vehicle: new VehicleDTO(year: 2018),
        );
    }
}
