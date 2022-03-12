<?php

namespace App\Services\Risk;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;
use App\Enums\ProfileEnum;
use App\Services\Risk\ScoreCalculators\AgeRiskScore;
use App\Services\Risk\ScoreCalculators\BaseRiskScore;
use App\Services\Risk\ScoreCalculators\DependentsRiskScore;
use App\Services\Risk\ScoreCalculators\HouseRiskScore;
use App\Services\Risk\ScoreCalculators\IncomeRiskScore;
use App\Services\Risk\ScoreCalculators\InelegibleRiskScore;
use App\Services\Risk\ScoreCalculators\MaritalStatusRiskScore;
use App\Services\Risk\ScoreCalculators\VehicleRiskScore;

class RiskProfileService
{
    protected ProfilesDTO $profiles;

    public function __construct(
        protected InputDTO $input
    ) {}

    public function calculate(): array
    {
        $this->profiles = (new BaseRiskScore($this->input))->calculate();

        (new InelegibleRiskScore($this->profiles, $this->input))->calculate();
        (new AgeRiskScore($this->profiles, $this->input))->calculate();
        (new IncomeRiskScore($this->profiles, $this->input))->calculate();
        (new HouseRiskScore($this->profiles, $this->input))->calculate();
        (new DependentsRiskScore($this->profiles, $this->input))->calculate();
        (new MaritalStatusRiskScore($this->profiles, $this->input))->calculate();
        (new VehicleRiskScore($this->profiles, $this->input))->calculate();

        return $this->scoreLabels();
    }

    private function scoreLabels(): array
    {
        return array_map(
            fn($line) => ProfileEnum::LABELS[max($line, 0)],
            $this->profiles->toArray()
        );
    }
}
