<?php

namespace App\Infrastructure\Bag;

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
    public const mixed TYPE_UNDEFINED = null;

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
     * @param string $argumentName
     *
     * @return string|null
     */
    public static function getArgumentType(string $argumentName): ?string
    {
        return self::RULES[$argumentName]['type'] ?? self::TYPE_UNDEFINED;
    }
}
