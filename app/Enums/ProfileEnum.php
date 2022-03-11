<?php

namespace App\Enums;

class ProfileEnum extends AbstractEnum
{
    public const INELIGIBLE = 'ineligible';
    public const ECONOMIC = 'economic';
    public const REGULAR = 'regular';
    public const RESPONSIBLE = 'responsible';

    public const PROFILES = [
        0 => ProfileEnum::ECONOMIC,
        1 => ProfileEnum::REGULAR,
        2 => ProfileEnum::REGULAR,
        3 => ProfileEnum::RESPONSIBLE,
    ];
}
