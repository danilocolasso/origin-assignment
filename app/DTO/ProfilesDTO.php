<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject as DTO;

class ProfilesDTO extends DTO
{
    public int $auto;
    public int $disability;
    public int $home;
    public int $life;
}
