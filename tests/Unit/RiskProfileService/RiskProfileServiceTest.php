<?php

namespace Tests\Unit\RiskProfileService;

use App\DTO\InputDTO;
use App\Services\Risk\RiskProfileService;
use Tests\TestCase;

class RiskProfileServiceTest extends TestCase
{
    /** @dataProvider validInputDataProvider */
    public function testServiceWithvalidInputVariationsShouldReturnCorrespondingInsuranceLines(array $input, array $expected): void
    {
        /** Act */
        $service = new RiskProfileService(new InputDTO($input));
        $output = $service->calculate();

        /** Assert */
        $this->assertEquals($expected, $output);
    }

    /** @dataProvider invalidInputDataProvider */
    public function testServiceWithInvalidParamsShouldThrowException(array $input, string $expected): void
    {
        /** Assert */
        $this->expectExceptionMessage($expected);

        /** Act */
        $service = new RiskProfileService(new InputDTO($input));
        $service->calculate();
    }

    public function validInputDataProvider(): array
    {
        return [
            'assignment' => [
                'input' => $this->getMockFile('Basic/input.json'),
                'expected' => $this->getMockFile('Basic/expected-output.json'),
            ],
            'no-house-vehicle-income' => [
                'input' => $this->getMockFile('NoHouseVehicleIncome/input.json'),
                'expected' => $this->getMockFile('NoHouseVehicleIncome/expected-output.json'),
            ],
            'age-over-60yo' => [
                'input' => $this->getMockFile('AgeOver60Yo/input.json'),
                'expected' => $this->getMockFile('AgeOver60Yo/expected-output.json'),
            ],
            'age-under-30yo' => [
                'input' => $this->getMockFile('AgeUnder30Yo/input.json'),
                'expected' => $this->getMockFile('AgeUnder30Yo/expected-output.json'),
            ],
            'age-between-30-40yo' => [
                'input' => $this->getMockFile('AgeBetween3040Yo/input.json'),
                'expected' => $this->getMockFile('AgeBetween3040Yo/expected-output.json'),
            ],
            'income-above-200k' => [
                'input' => $this->getMockFile('IncomeAbove200k/input.json'),
                'expected' => $this->getMockFile('IncomeAbove200k/expected-output.json'),
            ],
            'house-mortgaged' => [
                'input' => $this->getMockFile('HouseMortgaged/input.json'),
                'expected' => $this->getMockFile('HouseMortgaged/expected-output.json'),
            ],
            'no-dependents' => [
                'input' => $this->getMockFile('NoDependents/input.json'),
                'expected' => $this->getMockFile('NoDependents/expected-output.json'),
            ],
            'marital-status-single' => [
                'input' => $this->getMockFile('MaritalStatusSingle/input.json'),
                'expected' => $this->getMockFile('MaritalStatusSingle/expected-output.json'),
            ],
            'vehicle-5yo' => [
                'input' => $this->getMockFile('Vehicle5yo/input.json'),
                'expected' => $this->getMockFile('Vehicle5yo/expected-output.json'),
            ],
        ];
    }

    public function invalidInputDataProvider(): array
    {
        return [
            'invalid-house-and-vehicle' => [
                'input' => $this->getMockFile('InvalidHouseAndVehicle/input.json'),
                'expected' => 'Cannot assign string to property App\DTO\VehicleDTO::$year of type ?int',
            ],
            'without-some-fields' => [
                'input' => $this->getMockFile('WithoutSomeFields/input.json'),
                'expected' => 'Cannot assign null to property App\DTO\InputDTO::$dependents of type int',
            ],
        ];
    }
}
