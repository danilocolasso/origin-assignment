<?php

namespace App\Http\Services;

use App\Enums\HouseEnum;
use App\Enums\MaritalStatusEnum;
use App\Enums\ProfileEnum;
use Carbon\Carbon;

class RiskProfileService
{
    private array $insurance;

    public function __construct(
        private array $data,
    )
    {}

    public function calculate()
    {
        $this->calculateBaseScore();

        // TODO: Improve this

        $this->calcUserBetweenTirtyAndForty(); // 3
        $this->calcUsersIncomeAbove200k(); // 4
        $this->calcUsersHouseMortgaged(); // 5
        $this->calcUserHasDependents(); // 6
        $this->calcUserIsMarried(); // 7
        $this->calcUsersVehicle5yo(); // 8

        $this->setEachProfileBasedOnScore();

        $this->calcUserDesntHaveIncomeVehiclesOrHouses(); // 1
        $this->calcUserOverSixty(); // 2

        return $this->insurance;
    }

    private function calculateBaseScore(): void
    {
        $baseScore = array_sum($this->data['risk_questions']);

        $this->insurance = [
            'auto' => $baseScore,
            'disability' => $baseScore,
            'home' => $baseScore,
            'life' => $baseScore,
        ];
    }

    private function setEachProfileBasedOnScore()
    {
        $this->insurance = array_map(
            fn($item) => ProfileEnum::PROFILES[$item],
            $this->insurance
        );
    }

    private function calcUserDesntHaveIncomeVehiclesOrHouses()
    {
        if (!$this->data['income']) {
            $this->insurance['disability'] = ProfileEnum::INELIGIBLE;
        }

        if (!$this->data['vehicle']) {
            $this->insurance['auto'] = ProfileEnum::INELIGIBLE;
        }

        if (!$this->data['house']) {
            $this->insurance['home'] = ProfileEnum::INELIGIBLE;
        }
    }

    private function calcUserOverSixty()
    {
        if ($this->data['age'] > 60) {
            $this->insurance['disability'] = ProfileEnum::INELIGIBLE;
            $this->insurance['life'] = ProfileEnum::INELIGIBLE;
        }
    }

    private function calcUserBetweenTirtyAndForty()
    {
        if ($this->data['age'] < 30) {
            $this->deduct(2, 'all');
        } else if ($this->data['age'] < 40) {
            $this->deduct(1, 'all');
        }
    }

    private function calcUsersIncomeAbove200k()
    {
        if ($this->data['income'] > 200000) {
            $this->deduct(1, 'all');
        }
    }

    private function calcUsersHouseMortgaged()
    {
        if ($this->data['house'] && $this->data['house']['ownership_status'] === HouseEnum::MORTGAGED) {
            $this->add(1, ['home', 'disability']);
        }
    }

    private function calcUserHasDependents()
    {
        if ($this->data['dependents']) {
            $this->add(1, ['disability', 'life']);
        }
    }

    private function calcUserIsMarried()
    {
        if ($this->data['marital_status'] === MaritalStatusEnum::MARRIED) {
            $this->add(1, 'life');
            $this->deduct(1, 'disability');
        }
    }

    private function calcUsersVehicle5yo()
    {
        if ($this->data['vehicle'] && $this->data['vehicle']['year'] >= Carbon::today()->subYears(5)) {
            $this->add(1, 'auto');
        }
    }

    /** Just an alias to add calcScore */
    private function add(int $amount, string|array $lines): void
    {
        $this->calcScore('add', $amount, $lines);
    }

    /** Just an alias to deduct calcScore */
    private function deduct(int $amount, string|array $lines): void
    {
        $this->calcScore('deduct', $amount, $lines);
    }

    private function calcScore(string $operation, int $amount, string|array $lines)
    {
        $amount = $operation === 'add' ? abs($amount) : -$amount;

        if($lines && $lines !== 'all') {
            $lines = is_array($lines) ? $lines : [$lines];
            foreach ($lines as $line) {
                $this->insurance[$line] += $amount;
            }

            return;
        }

        $this->insurance = array_map(
            fn($value) => $value + $amount,
            $this->insurance
        );
    }
}
