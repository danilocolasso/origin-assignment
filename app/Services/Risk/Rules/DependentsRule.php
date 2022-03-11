<?php

namespace App\Services\Risk\Rules;

class DependentsRule extends AbstractRule
{
    public function calculate(): void
    {
        $this->calcUserHasDependents();
    }

    private function calcUserHasDependents(): void
    {
        if ($this->input->dependents) {
            $this->add(1, ['disability', 'life']);
        }
    }
}
