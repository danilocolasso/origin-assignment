<?php

namespace App\Http\Services\Risk;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;
use App\Enums\ProfileEnum;
use App\Rules\Risk\AgeRule;
use App\Rules\Risk\BaseScoreRule;
use App\Rules\Risk\DependentsRule;
use App\Rules\Risk\HouseRule;
use App\Rules\Risk\IncomeRule;
use App\Rules\Risk\InelegibleRule;
use App\Rules\Risk\MaritalStatusRule;
use App\Rules\Risk\VehicleRule;

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
