<?php

namespace App\Services\Risk\ScoreCalculators;

use App\Enums\ProfileEnum;

class InelegibleRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->userDesntHaveIncomeVehiclesOrHouses();
    }

    private function userDesntHaveIncomeVehiclesOrHouses(): void
    {
        if (!$this->input->income) {
            $this->profiles->disability = ProfileEnum::IMMUTABLE;
        }

        if (!$this->input->vehicle->year) {
            $this->profiles->auto = ProfileEnum::IMMUTABLE;
        }

        if (!$this->input->house->ownershipStatus) {
            $this->profiles->home = ProfileEnum::IMMUTABLE;
        }
    }
}
