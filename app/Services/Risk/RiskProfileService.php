<?php

namespace App\Services\Risk;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;
use App\Enums\ProfileEnum;
use App\Services\Risk\Rules\AgeRule;
use App\Services\Risk\Rules\BaseScoreRule;
use App\Services\Risk\Rules\DependentsRule;
use App\Services\Risk\Rules\HouseRule;
use App\Services\Risk\Rules\IncomeRule;
use App\Services\Risk\Rules\InelegibleRule;
use App\Services\Risk\Rules\MaritalStatusRule;
use App\Services\Risk\Rules\VehicleRule;

class RiskProfileService
{
    protected ProfilesDTO $profiles;

    public function __construct(
        protected InputDTO $input
    ) {}

    public function calculate(): array
    {
        $this->profiles = (new BaseScoreRule($this->input))->get();

        (new InelegibleRule($this->profiles, $this->input))->calculate();
        (new AgeRule($this->profiles, $this->input))->calculate();
        (new IncomeRule($this->profiles, $this->input))->calculate();
        (new HouseRule($this->profiles, $this->input))->calculate();
        (new DependentsRule($this->profiles, $this->input))->calculate();
        (new MaritalStatusRule($this->profiles, $this->input))->calculate();
        (new VehicleRule($this->profiles, $this->input))->calculate();

        return $this->scoreLabels();
    }

    private function scoreLabels(): array
    {
        return array_map(
            fn($line) => ProfileEnum::LABELS[$line],
            $this->profiles->toArray()
        );
    }
}
