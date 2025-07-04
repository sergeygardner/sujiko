<?php

declare(strict_types=1);

namespace App\Application\Tool;

final readonly class GaussSumTool
{
    public function getSum(int $value): int
    {
        return $value * ($value + 1) / 2;
    }
}
