<?php

namespace App\Services\Risk\Rules;

class IncomeRule extends AbstractRule
{
    public function calculate(): void
    {
        $this->usersIncomeAbove200k();
    }

    private function usersIncomeAbove200k(): void
    {
        if ($this->input->income > 200000) {
            $this->deduct(1, 'all');
        }
    }
}
