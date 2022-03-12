<?php

namespace App\Services\Risk\ScoreCalculators;

use App\Enums\ProfileEnum;

class AgeRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->userOverSixty();
        $this->userBetweenTirtyAndForty();
    }

    private function userOverSixty(): void
    {
        if ($this->input->age > 60) {
            $this->profiles->disability = ProfileEnum::IMMUTABLE;
            $this->profiles->life = ProfileEnum::IMMUTABLE;
        }
    }

    private function userBetweenTirtyAndForty(): void
    {
        if ($this->input->age < 30) {
            $this->deduct(2, 'all');
        } else if ($this->input->age < 40) {
            $this->deduct(1, 'all');
        }
    }
}
