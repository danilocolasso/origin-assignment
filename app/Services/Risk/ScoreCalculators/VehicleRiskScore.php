<?php

namespace App\Services\Risk\ScoreCalculators;

use Carbon\Carbon;

class VehicleRiskScore extends AbstractRiskScore
{
    public function calculate(): void
    {
        $this->usersVehicleLessThanFiveyears();
    }

    private function usersVehicleLessThanFiveyears(): void
    {
        if ($this->input->vehicle->year >= Carbon::today()->subYears(5)->year) {
            $this->add(1, 'auto');
        }
    }
}
