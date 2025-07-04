<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Infrastructure\Bag\OptionsBag;
use RuntimeException;

/**
 *
 */
final readonly class ConsoleOptionService
{
    /**
     * @param OptionsBag $options
     *
     * @example [SHORT_OPTIONS_AND_LONG_OPTIONS]
     *
     * @see     https://php.net/manual/en/function.getopt.php
     */
    public function __construct(public OptionsBag $options)
    {
    }

    /**
     * @return int
     */
    public function getMaxNumber(): int
    {
        return (int) ($this->options->maxNumber[0] ?? throw new RuntimeException('Max number can\'t be reached'));
    }

    /**
     * @return array<int, int>
     */
    public function getGroupSum(): array
    {
        return $this->options->groupSum[0] ?? throw new RuntimeException('Group sum can\'t be reached');
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function getGroups(): array
    {
        return $this->options->group ?? throw new RuntimeException('Groups can\'t be reached');
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function getTuples(): array
    {
        return $this->options->tuple ?? throw new RuntimeException('Tuples can\'t be reached');
    }
}
