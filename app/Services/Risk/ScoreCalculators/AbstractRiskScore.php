<?php

namespace App\Services\Risk\ScoreCalculators;

use App\DTO\InputDTO;
use App\DTO\ProfilesDTO;
use App\Enums\ProfileEnum;

abstract class AbstractRiskScore
{
    public function __construct(
        protected ProfilesDTO $profiles,
        protected InputDTO $input
    ) {}

    abstract public function calculate(): void;

    protected function add(int $amount, string|array $lines): void
    {
        $this->scoreCalculate('add', $amount, $lines);
    }

    protected function deduct(int $amount, string|array $lines): void
    {
        $this->scoreCalculate('deduct', $amount, $lines);
    }

    private function scoreCalculate(string $operation, int $amount, string|array $lines): void
    {
        $amount = $operation === 'add' ? abs($amount) : -$amount;
        $lines = $lines === 'all' ? array_keys($this->profiles->toArray()) : $lines;
        $lines = is_array($lines) ? $lines : [$lines];

        foreach ($lines as $line) {
            $this->profiles->$line += $this->isInelegible($this->profiles->$line) ? 0 : $amount;
        }
    }

    private function isInelegible(int $line): bool
    {
        return $line === ProfileEnum::IMMUTABLE;
    }
}
