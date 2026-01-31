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
    public static function dataProvider(): Generator
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

    /**
     * @dataProvider dataProvider
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
}
