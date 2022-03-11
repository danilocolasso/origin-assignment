<?php

namespace App\Enums;

class ProfileEnum extends AbstractEnum
{
    public const IMMUTABLE = -1;

    public const INELIGIBLE = 'ineligible';
    public const ECONOMIC = 'economic';
    public const REGULAR = 'regular';
    public const RESPONSIBLE = 'responsible';

    public const LABELS = [
        self::IMMUTABLE => self::INELIGIBLE,
        0 => self::ECONOMIC,
        1 => self::REGULAR,
        2 => self::REGULAR,
        3 => self::RESPONSIBLE,
    ];
}
