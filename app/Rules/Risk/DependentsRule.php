<?php

namespace App\Rules\Risk;

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
