<?php

namespace App\Services\Risk\ScoreCalculators;

use App\Enums\HouseEnum;

class HouseRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->usersHouseIsMortgaged();
    }

    private function usersHouseIsMortgaged(): void
    {
        if ($this->input->house->ownershipStatus === HouseEnum::MORTGAGED) {
            $this->add(1, ['home', 'disability']);
        }
    }
}
