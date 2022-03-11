<?php

namespace App\Services\Risk\Rules;

use App\Enums\HouseEnum;

class HouseRule extends AbstractRule
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
