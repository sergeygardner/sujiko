<?php

namespace App\Infrastructure\Bag;

use App\Domain\Exception\WrongArgumentTypeDomainException;

class OptionsBag
{
    /**
     *
     */
    public const string MAX_NUMBER = 'maxNumber';

    /**
     *
     */
    public const string GROUP_SUM = 'groupSum';

    /**
     *
     */
    public const string GROUP = 'group';

    /**
     *
     */
    public const string TUPLE = 'tuple';

    /**
     *
     */
    public const string TYPE_INT = 'int';

    /**
     *
     */
    public const string TYPE_INT_ARRAY = 'int_array';

    /**
     *
     */
    private const array RULES = [
        self::MAX_NUMBER => [
            'type' => self::TYPE_INT,
        ],
        self::GROUP_SUM => [
            'type' => self::TYPE_INT_ARRAY,
        ],
        self::GROUP => [
            'type' => self::TYPE_INT_ARRAY,
        ],
        self::TUPLE => [
            'type' => self::TYPE_INT_ARRAY,
        ],
    ];

    /**
     * @var array<int, int>
     */
    public array $maxNumber = [];

    /**
     * @var array<int, array<int, int>>
     */
    public array $groupSum = [];

    /**
     * @var array<int, array<int, int>>
     */
    public array $group = [];

    /**
     * @var array<int, array<int, int>>
     */
    public array $tuple = [];

    /**
     * @throws WrongArgumentTypeDomainException
     */
    public function setValue(string $fieldName, int $iterator, int|null $value): void
    {
        if (! property_exists($this, $fieldName)) {
            throw new WrongArgumentTypeDomainException(
                sprintf('Argument [%s] name is not supported', $fieldName),
            );
        }

        if ($value === null) {
            throw new WrongArgumentTypeDomainException(
                sprintf('Argument [%s] value is not supported', $fieldName),
            );
        }

        switch ($fieldName) {
            case self::MAX_NUMBER:
                $this->{$fieldName}[$iterator] = $value;
                break;
            case self::GROUP_SUM:
            case self::GROUP:
            case self::TUPLE:
                $this->{$fieldName}[$iterator] = [
                    ...($this->{$fieldName}[$iterator] ?? []),
                    $value,
                ];
                break;
        }
    }
}
