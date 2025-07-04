<?php

namespace Tests\Unit\App\Infrastructure\Service;

use App\Infrastructure\Bag\OptionsBag;
use App\Infrastructure\Service\ConsoleOptionService;
use Generator;
use PHPUnit\Framework\TestCase;

class ConsoleOptionServiceTest extends TestCase
{
    /**
     * @return Generator
     */
    public static function data_provider(): Generator
    {
        $optionsBag = new OptionsBag();
        $optionsBag->maxNumber = [9];
        $optionsBag->groupSum = [[1]];
        $optionsBag->group = [[2]];
        $optionsBag->tuple = [[4]];

        yield 'all' => [
            'options' => $optionsBag,
            'expectedMaxNumber' => 9,
            'expectedGroupSum' => [1],
            'expectedGroups' => [[2]],
            'expectedTuples' => [[4]],
            'exception' => null,
        ];
    }

    public static function type_data_provider(): Generator
    {
        yield OptionsBag::MAX_NUMBER => [
            'type' => OptionsBag::MAX_NUMBER,
            'expectedType' => OptionsBag::TYPE_INT,
        ];
        yield OptionsBag::GROUP => [
            'type' => OptionsBag::GROUP,
            'expectedType' => OptionsBag::TYPE_INT_ARRAY,
        ];
        yield OptionsBag::GROUP_SUM => [
            'type' => OptionsBag::GROUP_SUM,
            'expectedType' => OptionsBag::TYPE_INT_ARRAY,
        ];
        yield OptionsBag::TUPLE => [
            'type' => OptionsBag::TUPLE,
            'expectedType' => OptionsBag::TYPE_INT_ARRAY,
        ];
    }

    /**
     * @dataProvider data_provider
     *
     * @param OptionsBag $options
     * @param int $expectedMaxNumber
     * @param array $expectedGroupSum
     * @param array $expectedGroups
     * @param array $expectedTuples
     * @param string|null $exception
     *
     * @return void
     */
    public function testConstruct(
        OptionsBag $options,
        int $expectedMaxNumber,
        array $expectedGroupSum,
        array $expectedGroups,
        array $expectedTuples,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $consoleOptionService = new ConsoleOptionService($options);

        self::assertEquals($expectedMaxNumber, $consoleOptionService->getMaxNumber());
        self::assertEquals($expectedGroupSum, $consoleOptionService->getGroupSum());
        self::assertEquals($expectedGroups, $consoleOptionService->getGroups());
        self::assertEquals($expectedTuples, $consoleOptionService->getTuples());
    }

    /**
     * @dataProvider type_data_provider
     *
     * @param string $type
     * @param string $expectedType
     *
     * @return void
     */
    public function testGetArgumentType(
        string $type,
        string $expectedType,
    ): void {
        self::assertEquals($expectedType, OptionsBag::getArgumentType($type));
    }
}
