<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends ArrayCollection<int|string, int>
 */
class MatrixValueDTOCollection extends ArrayCollection
{
    /**
     * @var array<int, int|string>
     */
    private array $values = [];

    public function set(int|string $key, mixed $value): void
    {
        parent::set($key, $value);

        $this->values[$value] = $key;
    }

    public function hasValue(mixed $value): bool
    {
        return isset($this->values[$value]);
    }
}
