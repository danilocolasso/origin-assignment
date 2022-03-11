<?php

namespace App\Rules\Risk;

use App\Enums\ProfileEnum;

class InelegibleRule extends AbstractRule
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

        if (!$this->input->vehicle) {
            $this->profiles->auto = ProfileEnum::IMMUTABLE;
        }

        if (!$this->input->house) {
            $this->profiles->home = ProfileEnum::IMMUTABLE;
        }
    }
}
