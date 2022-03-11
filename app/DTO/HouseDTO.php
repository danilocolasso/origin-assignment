<?php

namespace App\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject as DTO;

class HouseDTO extends DTO
{
    #[
        MapFrom('ownership_status'),
        MapTo('ownership_status')
    ]
    public ?string $ownershipStatus;
}
