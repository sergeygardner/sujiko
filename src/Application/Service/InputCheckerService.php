<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Tool\GaussSumTool;
use App\Domain\Exception\WrongGroupSumDomainException;

final readonly class InputCheckerService
{
    public function __construct(
        private GaussSumTool $gaussSumTool,
    ) {
    }

    public function checkSum(
        int $maxNumber,
        int ...$groupsSum,
    ): void {
        if ($this->gaussSumTool->getSum($maxNumber) !== array_sum($groupsSum)) {
            throw new WrongGroupSumDomainException(
                sprintf(
                    'Group sum [%s] and max number [%s] are not correlated with each other',
                    var_export($groupsSum, true),
                    $maxNumber,
                ),
            );
        }
    }
}
