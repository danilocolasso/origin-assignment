<?php

namespace App\Rules\Risk;

use App\Enums\MaritalStatusEnum;

class MaritalStatusRule extends AbstractRule
{
    public function calculate(): void
    {
        $this->userIsMarried();
    }

    private function userIsMarried(): void
    {
        if ($this->input->maritalStatus === MaritalStatusEnum::MARRIED) {
            $this->add(1, 'life');
            $this->deduct(1, 'disability');
        }
    }
}
