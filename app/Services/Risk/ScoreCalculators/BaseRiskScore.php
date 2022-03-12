<?php

namespace App\Services\Risk\ScoreCalculators;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;

class BaseRiskScore
{
    protected ProfilesDTO $profiles;

    public function __construct(
        protected InputDTO $input
    ) {}

    public function calculate(): ProfilesDTO
    {
        $this->calculateByRiskQuestions();

        return $this->profiles;
    }

    private function calculateByRiskQuestions(): void
    {
        $baseScore = array_sum($this->input->riskQuestions);

        $this->profiles = new ProfilesDTO(
            auto: $baseScore,
            disability: $baseScore,
            home: $baseScore,
            life: $baseScore,
        );
    }
}
