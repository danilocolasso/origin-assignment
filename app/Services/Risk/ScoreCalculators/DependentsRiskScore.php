<?php

namespace App\Services\Risk\ScoreCalculators;

class DependentsRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->calcUserHasDependents();
    }

    private function calcUserHasDependents(): void
    {
        if ($this->input->dependents > 0) {
            $this->add(1, ['disability', 'life']);
        }
    }
}
