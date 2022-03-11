<?php

namespace App\Services\Risk\Rules;

use Carbon\Carbon;

class VehicleRule extends AbstractRule
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
