<?php

namespace App\Services\Risk\ScoreCalculators;

class IncomeRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->usersIncomeAbove200k();
    }

    private function usersIncomeAbove200k(): void
    {
        if ($this->input->income > 200000) {
            $this->deduct(1, 'all');
        }
    }
}
