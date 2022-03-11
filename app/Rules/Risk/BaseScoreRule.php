<?php

namespace App\Rules\Risk;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;

class BaseScoreRule
{
    protected ProfilesDTO $profiles;

    public function __construct(
        protected InputDTO $input
    ) {}

    public function get(): ProfilesDTO
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
