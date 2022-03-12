<?php

namespace App\Services\Risk\ScoreCalculators;

use App\Enums\MaritalStatusEnum;

class MaritalStatusRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->userIsMarried();
    }

    private function userIsMarried(): void
    {
        if ($this->input->maritalStatus === MaritalStatusEnum::MARRIED) {
            $this->add(1, 'life');
            $this->deduct(1, 'disability');
        }
    }
}
