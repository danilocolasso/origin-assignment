<?php

namespace App\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject as DTO;

class InputDTO extends DTO
{
    public int $age;
    public int $dependents;
    public HouseDTO $house;
    public int $income;

    #[
        MapFrom('marital_status'),
        MapTo('marital_status')
    ]
    public string $maritalStatus;

    #[
        MapFrom('risk_questions'),
        MapTo('risk_question')
    ]
    public array $riskQuestions;

    public VehicleDTO $vehicle;
}
